# Date Anime :

Date Anime is an application allowed you to choose if you like a anime or not and building a watchlist with these anime.
(WIP)

Actually nothing is done yet. I mainly building thebase application.

Available :
- Account creation
- Login
- Seeing UpComing anime
- Seeing Anime available in the database (Define in whene you select ou you like or not)
- Add anime in DB (admin only)


WIP :
- Able to like anime or dislike
- Be able to see directly anime if you really like this anime
- See your profile and updated it
- Look profile of other
- See your watchlist
- Nice question ^^

## Installation
### Requirements
- Docker

### Setup
- Clone the repository
- Run the following command :
    ```
    docker-compose up -d
    ```
- Run the following command for install php dependencies :
    ```
    docker-compose exec engine php composer install
    ```
- Run the following command for setting up the database and set default user :
    ```
    docker-compose exec engine composer run-script init_db
    ```
- You can now access the application on http://dateanime.localhost
 
