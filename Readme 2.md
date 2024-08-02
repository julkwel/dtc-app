## Digital Training Center Web Application

**Requirements :**
1. `php 8.2+`
2. `symfony cli`
3. `docker installed`

**Installation :**
1. Clone this repository
2. Go to path
3. Run `docker compose up --build` (asume docker service is started)
4. Update your database schema : `docker exec -d dtc-app /var/www/dtc-app/bin/console d:s:u -f`
5. Navigate to : `localhost:8080`

*Go ahead !*