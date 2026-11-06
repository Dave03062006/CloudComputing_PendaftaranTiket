#!/bin/bash
# Auto-deploy for tiket1.ked.my.id, run by a CloudPanel cron job as ked-tiket1.
# Every run: pull the latest main from GitHub and, if it changed, redeploy Laravel.
# Output goes to ~/htdocs/deploy.log (readable in CloudPanel File Manager).

export PATH="/usr/local/bin:/usr/bin:/bin:$PATH"

REPO_SSH="git@github.com:Dave03062006/CloudComputing_PendaftaranTiket.git"
REPO_DIR="$HOME/htdocs/tiket1-repo"          # where the repo gets cloned
OLD_SITE="$HOME/htdocs/tiket1.ked.my.id"     # current site, used to copy its .env
KEY="$HOME/.ssh/github_deploy"
export GIT_SSH_COMMAND="ssh -i $KEY -o IdentitiesOnly=yes -o StrictHostKeyChecking=accept-new"

log() { echo "$(date '+%F %T') $*"; }

# 1. One-time: create a deploy key. Its public half is written to
#    ~/htdocs/github_deploy_key.txt so it can be copied from File Manager.
if [ ! -f "$KEY" ]; then
  mkdir -p "$HOME/.ssh" && chmod 700 "$HOME/.ssh"
  ssh-keygen -t ed25519 -N "" -C "tiket1-server" -f "$KEY" -q
  cp "$KEY.pub" "$HOME/htdocs/github_deploy_key.txt"
  log "Deploy key created: add htdocs/github_deploy_key.txt to GitHub > Settings > Deploy keys"
fi

# 2. Clone once (keeps retrying each run until the deploy key is added on GitHub),
#    then on later runs only continue when GitHub has new commits.
if [ ! -d "$REPO_DIR/.git" ]; then
  if ! git clone -q "$REPO_SSH" "$REPO_DIR" 2>/dev/null; then
    log "Clone failed - deploy key not added on GitHub yet"
    exit 0
  fi
  log "Repo cloned"
  cd "$REPO_DIR" || exit 1
else
  cd "$REPO_DIR" || exit 1
  git fetch -q origin main || { log "Fetch failed"; exit 0; }
  if [ "$(git rev-parse HEAD)" = "$(git rev-parse origin/main)" ]; then
    # No new commits. If .env was edited since the last config cache, re-cache it.
    cd "$REPO_DIR/laravel" || exit 1
    if [ .env -nt bootstrap/cache/config.php ]; then
      php artisan config:cache >/dev/null && log "Re-cached config after .env change"
    fi
    exit 0
  fi
  git reset -q --hard origin/main
fi

# 3. Deploy the Laravel app in laravel/.
cd "$REPO_DIR/laravel" || exit 1
if [ ! -f .env ]; then
  cp "$OLD_SITE/.env" .env 2>/dev/null || cp .env.example .env
  log "Created .env (check DB and mail settings in File Manager)"
fi
composer install --no-dev --optimize-autoloader --no-interaction --quiet
grep -q '^APP_KEY=base64' .env || php artisan key:generate --force
php artisan migrate --force
php artisan storage:link 2>/dev/null
php artisan config:cache && php artisan route:cache && php artisan view:cache
log "Deployed $(git rev-parse --short HEAD)"
