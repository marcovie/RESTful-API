<?php

namespace App\Http\Controllers\API\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

interface iExpenseInterface
{
    /**
     * @OA\Schema(
     *   schema="items",
     *   @OA\Property(
     *    property="id",
     *      type="integer"
     *   ),
     *   @OA\Property(
     *      property="amount",
     *      type="string"
     *   ),
     *   @OA\Property(
     *      property="description",
     *      type="string"
     *   ),
     *   @OA\Property(
     *      property="created_at",
     *      type="string"
     *   ),
     *   @OA\Property(
     *      property="updated_at",
     *      type="string"
     *   ),
     * )
     */

     /**
      * @OA\Schema(
      *   schema="post",
      *   @OA\Property(
      *     property="amount",
      *     type="integer"
      *   ),
      *   @OA\Property(
      *     property="description",
      *     type="string"
      *   ),
      * )
      */

    public function __construct();

    /**
     * @OA\GET(
     *     path="/api/1.0/expense",
     *     summary="Get a list of expenses - linked to your user",
     *     description="Returns list of expenses",
     *     tags={"expense.index"},
     *     @OA\Parameter(
     *          name="sort",
     *          description="specific field",
     *          required=false,
     *          in="path",
     *          @OA\Schema(
     *              type="string"
     *          ),
     *        ),
     *     @OA\Parameter(
     *          name="orderby",
     *          description="desc or asc",
     *          required=false,
     *          in="path",
     *          @OA\Schema(
     *              type="string",
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="from_date",
     *          description="YYYY-MM-DD",
     *          required=false,
     *          in="path",
     *          @OA\Schema(
     *              type="string",
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="to_date",
     *          description="YYYY-MM-DD",
     *          required=false,
     *          in="path",
     *          @OA\Schema(
     *              type="string",
     *          )
     *      ),
     *     @OA\Response(
     *        response="200",
     *        description="Successful response",
     *        @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                property="expenseItems",
     *                type="array",
     *                example={
     *                  "current_page": 1,
     *                      "data": {
     *                          {
     *                              "id": 1,
     *                              "amount": "50.00",
     *                              "description": "Fuel",
     *                              "created_at": "2020-08-23 05:38:24",
     *                              "updated_at": "2020-08-23 05:38:24"
     *                          },
     *	                        {
     *                              "id": 2,
     *                              "amount": "50.00",
     *                              "description": "Fuel",
     *                              "created_at": "2020-08-23 05:38:24",
     *                              "updated_at": "2020-08-23 05:38:24"
     *                          },
     *                      },
     *                      "first_page_url": "http://127.0.0.1:8000/api/1.0/expense?page=1",
     *                      "from": 1,
     *                      "last_page": 1,
     *                      "last_page_url": "http://127.0.0.1:8000/api/1.0/expense?page=1",
     *                      "next_page_url": null,
     *                      "path": "http://127.0.0.1:8000/api/1.0/expense",
     *                      "per_page": 5,
     *                      "prev_page_url": null,
     *                      "to": 2,
     *                      "total": 2
     *                  },
     *                @OA\Items(ref="#/components/schemas/items"),
     *             ),
     *        ),
     *     ),
     *     @OA\Response(
     *        response=403,
     *        description="403 Forbidden"
     *     )
     * )
     */
    public function index(Request $request);

    /**
     * @OA\Post(
     *      path="/api/1.0/expense",
     *      summary="Store new expense - linked to your user",
     *      description="Returns the stored expenses",
     *      tags={"expense.store"},
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/post")
     *      ),
     *      @OA\Response(
     *        response="201",
     *        description="Successful created",
     *        @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                property="expenseItems",
     *                type="array",
     *                example={
     *                    "id": 1,
     *                    "amount": "50.00",
     *                    "description": "Fuel",
     *                    "created_at": "2020-08-23 05:38:24",
     *                    "updated_at": "2020-08-23 05:38:24"
     *                  },
     *                  @OA\Items(ref="#/components/schemas/items"),
     *             ),
     *        ),
     *     ),
     *      @OA\Response(
     *          response=400,
     *          description="Bad Request"
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      )
     * )
     */
    public function store(Request $request);

    /**
     * @OA\Get(
     *      path="/expense/{id}",
     *      tags={"expense.show"},
     *      summary="Get expense information - linked to your user",
     *      description="Returns expense data",
     *      @OA\Parameter(
     *          name="id",
     *          description="expense id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(ref="#/components/schemas/items")
     *       ),
     *      @OA\Response(
     *          response=404,
     *          description="Not found"
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      )
     * )
     */
    public function show($id);

    /**
     * @OA\Put(
     *      path="/expense/{id}",
     *      tags={"expense.update"},
     *      summary="Update existing expense - linked to your user",
     *      description="Returns updated expense data",
     *      @OA\Parameter(
     *          name="id",
     *          description="expense id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/post")
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful updated",
     *          @OA\JsonContent(ref="#/components/schemas/items")
     *       ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Not Found"
     *      )
     * )
     */
    public function update(Request $request, $id);

    /**
     * @OA\Delete(
     *      path="/expense/{id}",
     *      tags={"expense.destroy"},
     *      summary="Delete existing expense - linked to your user",
     *      description="Deletes a record and returns no content",
     *      @OA\Parameter(
     *          name="id",
     *          description="expense id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Response(
     *          response=204,
     *          description="No content",
     *          @OA\JsonContent()
     *       ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Not Found"
     *      )
     * )
     */
    public function destroy($id);
}
