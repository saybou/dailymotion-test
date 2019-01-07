# dailymotion-test

Task : The task was to create an api that manages an ordered playlist.

## SETUP

Clone repository : git clone https://github.com/saybou/dailymotion-test.git .

From project root folder, run :

    $ docker-compose build
    $ docker-compose up -d

Attach to container docker-php-apache and run composer install :
    
    $ docker exec -ti docker-php-apache /bin/bash
    $ composer install

From local machine (create tables with some data) :

    $ docker exec -i docker-mysql mysql -udocker -pdockermysql -D dailymotion-test < api/src/Resources/sql/Database.sql

---

## Test API

*It's possible to use a tool like **Postman** so you can test differents API calls : POST, PATCH, DELETE...*

* List videos (GET) : http://api.dailymotion-test.fr:8080/videos

* Show video info (GET) : http://api.dailymotion-test.fr:8080/videos/1

* List playlists (GET) : http://api.dailymotion-test.fr:8080/playlists

* Show playlist info (GET) : http://api.dailymotion-test.fr:8080/playlists/1

* Create video (POST) : http://api.dailymotion-test.fr:8080/videos
    ```
    {
      "data": {
        "name": "New video from post",
        "thumbnail": "http://"
      }
    }
    ```

* Create playlist (POST) : http://api.dailymotion-test.fr:8080/playlists
    ```
    {
      "data": {
        "title": "Playlist created with API"
      }
    }
    ```

* Update playlist (PATCH) : http://api.dailymotion-test.fr:8080/playlists/3
    ```
    {
      "data": {
        "title": "Playlist updated with API"
      }
    }
    ```

* Remove playlist (DELETE) : http://api.dailymotion-test.fr:8080/playlists/1

* Add video to playlist (POST) : http://api.dailymotion-test.fr:8080/playlists/2/video/4

* Remove video from playlist (DELETE) : http://api.dailymotion-test.fr:8080/playlists/2/video/4

* List videos from playlist (GET) : http://api.dailymotion-test.fr:8080/playlists/2/videos