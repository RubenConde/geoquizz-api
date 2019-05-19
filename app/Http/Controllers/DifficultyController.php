<?php

namespace App\Http\Controllers;

use App\Difficulty;
use App\Http\Controllers\Api\BaseController;
use App\Http\Resources\DifficultyResource;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

class DifficultyController extends BaseController
{
    /**
     * @return Response
     */
    public function index()
    {
        $difficulties = []; //The final difficulties array
        $page = Input::get('page', 1); //Page parameter in GET, default = 1
        $limit = Input::get('limit', 25); //Limit parameter in GET, default = 25
        $inputFields = Input::get('fields', 'id,name'); //String result from fields parameter in GET
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
        $count = Difficulty::all()->count(); //Count of all the difficultys
        $offset = (--$page) * $limit; // Number of elements that will going to be ignored
        $lastPage = ceil($count / $limit); //Value of last page in the pagination
        $dbDiffQ = Difficulty::query(); //Creation of a query for difficultys

        //Get all the difficultys with the selected columns, the number of hidden elements and how many there is
        //going to appear and the order parameters for the result
        $dbDiffQ->select($fields)->skip($offset)->take($limit)->orderBy($sort, $order);

        if ($filter !== null) { //If there is a change in the filter parameters
            foreach ($filterData as $filterDatum) {
                //For each filter, the second parameter is going to be evaluated (operator)
                switch ($filterDatum[1]) {
                    case 'like':
                        $dbDiffQ->where($filterDatum[0], 'LIKE', '%' . $filterDatum[2] . '%');
                        break;
                    case '=':
                        $dbDiffQ->where($filterDatum[0], $filterDatum[1], $filterDatum[2]);
                        break;
                    case '!=':
                        $dbDiffQ->where($filterDatum[0], $filterDatum[1], $filterDatum[2]);
                        break;
                    case '<':
                        $dbDiffQ->where($filterDatum[0], $filterDatum[1], $filterDatum[2]);
                        break;
                    case '<=':
                        $dbDiffQ->where($filterDatum[0], $filterDatum[1], $filterDatum[2]);
                        break;
                    case '>':
                        $dbDiffQ->where($filterDatum[0], $filterDatum[1], $filterDatum[2]);
                        break;
                    case '>=':
                        $dbDiffQ->where($filterDatum[0], $filterDatum[1], $filterDatum[2]);
                        break;
                    default:
                        //If it's different an error is sent
                        return $this->sendError('You have a syntax error in the filter. Filter only accepts: like, =, >, >=, <, <=, !=', [], 400);
                }
            }
        }

        //Execution of the entire request
        $dbDiff = DifficultyResource::collection($dbDiffQ->get());

        foreach ($dbDiff as $difficulty) {
            //Each element in the database response is added to the $difficultys array
            array_push($difficulties, ['difficulty' => $difficulty,
                'links' => ['self' => ['href' => route('difficulty', ['difficulties' => $difficulty])]]]);
        }

        //Links for pagination created
        $prev = ['href' => route('difficulties') . '?page=' . ($page)];
        $next = ['href' => route('difficulties') . '?page=' . ($page + 2)];
        $first = ['href' => route('difficulties') . '?page=1'];
        $last = ['href' => route('difficulties') . '?page=' . $lastPage];

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
        if ($fields !== ['id', 'name']) {
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
            'count' => count($difficulties),
            'difficulties' => $difficulties,
            'links' => [
                'prev' => $prev,
                'next' => $next,
                'first' => $first,
                'last' => $last
            ]
        ];

        //Return of a successful response
        return $this->sendResponse($data, 'Difficulties retrieved successfully.', 206, 'collection');
    }

    /**
     * @param Difficulty $difficulty
     * @return Response
     */
    public function show(Difficulty $difficulty)
    {
        //Difficulty obtained from database
        $dbDifficulty = new DifficultyResource($difficulty);
        $gamesDiff = $dbDifficulty->games()->get(['id', 'player']);
        $games = [];
        foreach ($gamesDiff as $gameDiff) {
            array_push($games, [
                'game' => $gameDiff,
                'href' => route('game', ['game' => $gameDiff->id]) //route() is to get te URI of and specific route
            ]);
        }

        //Construction of data
        $dbDifficulty['games'] = $games;
        $dbDifficulty['links'] = ['self' => ['href' => route('difficulty', ['difficulty' => $difficulty])]];

        $data = ['difficulty' => $dbDifficulty,];

        //Return of a successful response
        return $this->sendResponse($data, 'Difficulty retrieved successfully.');
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
            'name' => 'required',
            'distance' => 'required|numeric',
            'numberOfPhotos' => 'required|numeric',
        ]);
        if ($validator->fails()) {
            //If the parameters doesnt make the validation, errors are obtained from $validator
            $errors = $validator->errors();
            //An error is sent
            return $this->sendError('There was an error with the fields.', $errors, 400);
        }

        //If all the validations are right the new difficulty is created
        $difficulty = Difficulty::create($params);
        //The new difficulty is searched in the database
        $difficultyAfterCreate = Difficulty::find($difficulty->id);

        //Response of a successful result
        return $this->sendResponse(new DifficultyResource($difficultyAfterCreate), 'Difficulty created successfully.', 201);
    }

    /**
     * @param Request $request
     * @param Difficulty $difficulty
     * @return Response
     */
    public function update(Request $request, Difficulty $difficulty)
    {
        //PUT parameters are obtained from the request
        $params = $request->all();

        //Validation for the parameters
        $validator = Validator::make($params, [
            'distance' => 'numeric',
            'numberOfPhotos' => 'numeric',
        ]);
        if ($validator->fails()) {
            //If the parameters doesnt make the validation, errors are obtained from $validator
            $errors = $validator->errors();
            //An error is sent
            return $this->sendError('There was an error with the fields.', $errors, 400);
        }

        //If all the validations are right the difficulty is updated
        $difficulty->update($params);

        //Response of a successful result
        return $this->sendResponse(new DifficultyResource($difficulty), 'Difficulty updated successfully.', 200);
    }

    /**
     * @param Difficulty $difficulty
     * @return Response
     * @throws Exception
     */
    public function destroy(Difficulty $difficulty)
    {
        //Deletion of the sent difficulty
        $difficulty->delete();

        //Response with status 204 (No Content)
        return $this->sendResponse("", [], 204);
    }

}
