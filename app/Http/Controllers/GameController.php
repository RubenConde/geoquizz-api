<?php

namespace App\Http\Controllers;

use App\Game;
use App\Http\Controllers\Api\BaseController;
use App\Http\Resources\GameResource;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

class GameController extends BaseController
{
    /**
     * @return Response
     */
    public function index()
    {
        $games = []; //The final games array
        $page = Input::get('page', 1); //Page parameter in GET, default = 1
        $limit = Input::get('limit', 25); //Limit parameter in GET, default = 25
        $inputFields = Input::get('fields', 'id,player'); //String result from fields parameter in GET
        $fields = explode(',', $inputFields); //Array of fields parameter in GET separated
        $sort = Input::get('sort', 'id'); //Sort parameter in GET, default = id
        $order = Input::get('order', 'asc'); //Order parameter in GET, default = asc
        $filter = Input::get('filter'); //String result from filter parameter in GET, default = null
        $filterFields = explode(',', $filter); //Array for each filter field in filter parameter in GET
        $filterData = []; // Final array of filter data
        foreach ($filterFields as $filterField) {
            //Separation of fields in the filters to an array
            array_push($filterData, explode(':', $filterField));
        }
        $count = Game::all()->count(); //Count of all the games
        $offset = (--$page) * $limit; // Number of elements that will going to be ignored
        $lastPage = ceil($count / $limit); //Value of last page in the pagination
        $dbGamesQ = Game::query(); //Creation of a query for games

        //Get all the games with the selected columns, the number of hidden elements and how many there is
        //going to appear and the order parameters for the result
        $dbGamesQ->select($fields)->skip($offset)->take($limit)->orderBy($sort, $order);

        if ($filter !== null) { //If there is a change in the filter parameters
            foreach ($filterData as $filterDatum) {
                //For each filter, the second parameter is going to be evaluated (operator)
                switch ($filterDatum[1]) {
                    case 'like':
                        $dbGamesQ->where($filterDatum[0], 'LIKE', '%' . $filterDatum[2] . '%');
                        break;
                    case '=':
                        $dbGamesQ->where($filterDatum[0], $filterDatum[1], $filterDatum[2]);
                        break;
                    case '!=':
                        $dbGamesQ->where($filterDatum[0], $filterDatum[1], $filterDatum[2]);
                        break;
                    case '<':
                        $dbGamesQ->where($filterDatum[0], $filterDatum[1], $filterDatum[2]);
                        break;
                    case '<=':
                        $dbGamesQ->where($filterDatum[0], $filterDatum[1], $filterDatum[2]);
                        break;
                    case '>':
                        $dbGamesQ->where($filterDatum[0], $filterDatum[1], $filterDatum[2]);
                        break;
                    case '>=':
                        $dbGamesQ->where($filterDatum[0], $filterDatum[1], $filterDatum[2]);
                        break;
                    default:
                        //If it's different an error is sent
                        return $this->sendError('You have a syntax error in the filter. Filter only accepts: like, =, >, >=, <, <=, !=', [], 400);
                }
            }
        }

        //Execution of the entire request
        $dbGames = GameResource::collection($dbGamesQ->get());

        foreach ($dbGames as $game) {
            //Each element in the database response is added to the $games array
            array_push($games, ['game' => $game,
                'links' => ['self' => ['href' => route('game', ['games' => $game])]]]);
        }

        //Links for pagination created
        $prev = ['href' => route('games') . '?page=' . ($page)];
        $next = ['href' => route('games') . '?page=' . ($page + 2)];
        $first = ['href' => route('games') . '?page=1'];
        $last = ['href' => route('games') . '?page=' . $lastPage];

        //If the route is for the first page the link for the previous pager will be the same than the first page
        if ($page == 0) {
            $prev = $first;
        }

        //If the route is for the last page the link for the next pager will be the same than the last page
        if ($page + 1 == $lastPage) {
            $next = $last;
        }

        //If $limit is different than default, GET parameter is added in the pagination links
        if ($limit !== 25) {
            $prev['href'] .= '&limit=' . $limit;
            $next['href'] .= '&limit=' . $limit;
            $first['href'] .= '&limit=' . $limit;
            $last['href'] .= '&limit=' . $limit;
        }

        //If $sort is different than default, GET parameter is added in pagination links
        if ($sort !== 'id') {
            $prev['href'] .= '&sort=' . $sort;
            $next['href'] .= '&sort=' . $sort;
            $first['href'] .= '&sort=' . $sort;
            $last['href'] .= '&sort=' . $sort;
        }

        //If $order is different than default, GET parameter is added in pagination links
        if ($order !== 'asc') {
            $prev['href'] .= '&order=' . $order;
            $next['href'] .= '&order=' . $order;
            $first['href'] .= '&order=' . $order;
            $last['href'] .= '&order=' . $order;
        }

        //If $fields is different than default, GET parameter is added in pagination links
        if ($fields !== ['id', 'player']) {
            $prev['href'] .= '&fields=' . implode(',', $fields);
            $next['href'] .= '&fields=' . implode(',', $fields);
            $first['href'] .= '&fields=' . implode(',', $fields);
            $last['href'] .= '&fields=' . implode(',', $fields);
        }

        //If $filter is different than default, GET parameter is added in pagination links
        if ($filter !== null) {
            $prev['href'] .= '&filter=' . $filter;
            $next['href'] .= '&filter=' . $filter;
            $first['href'] .= '&filter=' . $filter;
            $last['href'] .= '&filter=' . $filter;
        }

        //Construction of the response
        $data = [
            'count' => count($games),
            'games' => $games,
            'links' => [
                'prev' => $prev,
                'next' => $next,
                'first' => $first,
                'last' => $last
            ]
        ];

        //Return of a successful response
        return $this->sendResponse($data, 'Games retrieved successfully.', 206, 'collection');
    }

    /**
     * @param Game $game
     * @return Response
     */
    public function show(Game $game)
    {
        //Game obtained from database
        $dbGame = new GameResource($game);

        $seriesGames = $dbGame->series()->get(['id', 'city']);
        $series = [];
        foreach ($seriesGames as $seriesGame) {
            array_push($series, [
                'series' => $seriesGame,
                'links' => ['href' => route('aSeries', ['series' => $seriesGame->id])]//route() is to get te URI of and specific route
            ]);
        }
        $difficultiesGames = $dbGame->difficulty()->get(['id', 'name']);
        $difficulties = [];
        foreach ($difficultiesGames as $difficultiesGame) {
            array_push($difficulties, [
                'difficulty' => $difficultiesGame,
                'links' => ['href' => route('aSeries', ['series' => $difficultiesGame->id])]//route() is to get te URI of and specific route
            ]);
        }


        //Construction of data
        $dbGame['series'] = $series;
        $dbGame['difficulties'] = $difficulties;
        $dbGame['links'] = ['self' => ['href' => route('game', ['game' => $game])]];

        $data = ['game' => $dbGame];

        //Return of a successful response
        return $this->sendResponse($data, 'Game retrieved successfully.');
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        //POST parameters are obtained from the request
        $params = $request->all();

        //Validation for the parameters
        $validator = Validator::make($params, [
            'status' => 'numeric',
            'score' => 'numeric',
            'player' => 'required',
            'idSeries' => 'required|numeric|exists:series,id',
            'idDifficulty' => 'required|numeric|exists:difficulties,id',
        ]);
        if ($validator->fails()) {
            //If the parameters doesnt make the validation, errors are obtained from $validator
            $errors = $validator->errors();
            //An error is sent
            return $this->sendError('There was an error!', $errors, 400);
        }

        //If all the validations are right the new game is created
        $game = Game::create($params);
        //The new game is searched in the database
        $gameAfterCreate = Game::find($game->id);

        //Response of a successful result
        return $this->sendResponse(new GameResource($gameAfterCreate), 'Game created successfully.', 201);
    }

    /**
     * @param Request $request
     * @param Game $game
     * @return Response
     */
    public function update(Request $request, Game $game)
    {
        //PUT parameters are obtained from the request
        $params = $request->all();

        //Validation for the parameters
        $validator = Validator::make($params, [
            'status' => 'numeric',
            'score' => 'numeric',
            'idSeries' => 'numeric|exists:series,id',
            'idDifficulty' => 'numeric|exists:difficulties,id',
        ]);
        if ($validator->fails()) {
            //If the parameters doesnt make the validation, errors are obtained from $validator
            $errors = $validator->errors();
            //An error is sent
            return $this->sendError('There was an error!', $errors, 400);
        }

        //If all the validations are right the game is updated
        $game->update($params);

        //Response of a successful result
        return $this->sendResponse(new GameResource($game), 'Game updated successfully.', 200);
    }

    /**
     * @param Game $game
     * @return Response
     * @throws Exception
     */
    public function destroy(Game $game)
    {
        //Deletion of the sent game
        $game->delete();

        //Response with status 204 (No Content)
        return $this->sendResponse("", [], 204);
    }
}