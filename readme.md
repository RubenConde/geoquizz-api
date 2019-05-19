<p  align="center">
<img  src="https://geoquizz.rubencondemag.info/img/world.28acccfd.png" width=200>
</p>
<p  align="center">
<a  href="https://geoquizz-api.herokuapp.com/"><img  src="https://heroku-badge.herokuapp.com/?app=geoquizz-api"  alt="Build Status"></a>
</p>

#  About GéoQuizz API
GéoQuizz API is a RESTful API for the consumption of the game of the same name, made mainly in PHP using the Laravel framework in its version 5.8 and deployed in a heroku server for its use.
## Endpoints
### Games
*  #### Table information
    | Field        | Type      | Description                                                                             |
    | ------------ | --------- | --------------------------------------------------------------------------------------- |
    | id           | integer   | Game identifier                                                                         |
    | player       | string    | Name of the player                                                                      |
    | status       | integer   | Game status `0 = completed` `1 = started` `2 = completed but not visible in scoreboard` |
    | score        | integer   | Game score                                                                              |
    | idSeries     | integer   | Identifier of the series to which it belongs                                            |
    | idDifficulty | integer   | Identifier of the difficulty to which it belongs                                        |
    | created_at   | timestamp | Date the record was created                                                             |
    | updated_at   | timestamp | Date the record was created                                                             |
*  #### URL
    `/api/v1/games`
*  #### Method
    `GET` `POST`
*  #### URL Params
	* ##### Required:
    	`...`
	* ##### Optional:
		* `page = [numeric] | default = 1`

            *Used to specify the page number you want to access.*
		* `limit = [numeric] | default = 25`

            *Used to specify the maximum number of elements on a page of the answer.*
        * `fields = [alphanumeric] | default = id,player`

            *Used to specify the fields to get from the list items, it will give one of them separated by a comma.*
		* `sort = [alphabetic] | default = id`

            *Used to specify a field by which to sort items in the list.*
		* `order = [alphabetic] | default = asc`

            *Used to specify a field by which to sort items in the list.*
		* `filter = [alphanumeric] | default = null`

            *Used to get a list filtered by a field giving a specific value. These are separated by a colon. e.g. = `field:operator:value`. Available operators: `=, !=, <, <=, >, >=`*
*  #### Data Params
   * ##### Required:
        `player` `idSeries` `idDifficulty`
   * ##### Optional:
        `status` `score`
*  #### Success Response:
   * ##### `206 Partial Content`
     * ##### Content: 
        ```json
        {
        "success": true,
        "type": "collection",
        "message": "Games retrieved successfully.",
        "data": {
            "count": 25,
            "games": [
                {
                    "game": {
                        "id": 1,
                        "player": "Raegan Carter"
                    },
                    "links": {
                        "self": {
                            "href": "http://127.0.0.1:8000/api/v1/games/1"
                        }
                    }
                },
                {
                    "..."
                }
            ],
            "links": {
                "prev": {
                    "href": "http://127.0.0.1:8000/api/v1/games?page=1"
                },
                "next": {
                    "href": "http://127.0.0.1:8000/api/v1/games?page=2"
                },
                "first": {
                    "href": "http://127.0.0.1:8000/api/v1/games?page=1"
                },
                "last": {
                    "href": "http://127.0.0.1:8000/api/v1/games?page=2"
                }
            }
        }
*  #### Error Response:
   * ##### `405 Method Not Allowed`
     * ##### Content:
        ```json 
        {    
        "success": false,
        "type": "error",
        "status": 405,
        "message": "The PUT method is not supported for this route. Supported methods: GET, HEAD, POST."
        }
   * ##### `400 Bad Request`
     * ##### Content:
        ```json 
        {
            "success": false,
            "type": "error",
            "status": 400,
            "message": "There was an error with the fields.",
            "errors": {
                "status": [
                    "The status must be a number.",
                    "The status must be between 0 and 2."
                ],
                "score": [
                    "The score must be a number."
                ],
                "player": [
                    "The player field is required."
                ],
                "idSeries": [
                    "The id series must be a number.",
                    "The id series field is required.",
                    "The selected id series is invalid."
                ],
                "idDifficulty": [
                    "The id difficulty must be a number.",
                    "The id difficulty field is required.",
                    "The selected id difficulty is invalid."
                ]
            }
        }
#  License
[MIT license](https://opensource.org/licenses/MIT).
