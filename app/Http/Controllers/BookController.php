<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Book::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            "title" => "required",
            "author" => "required",
            "year" => "required",
            "read" => "required"
        ]);

        return Book::create($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $book = Book::find($id);

        //Kontroll om ID finns i databasen. Returnerar om ID finns, annars felmeddelande 404 Not found.
        if($book != null) {
            return $book;
        } else {
            return response()->json(
                ["Boken finns inte!"
            ], 404);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $book = Book::find($id);

        //Kontroll om ID finns i databasen.
        if($book != null) {

            //Om ID finns, validera input
            $request->validate([
                "title" => "required",
                "author" => "required",
                "year" => "required",
                "read" => "required"
            ]);

            //Uppdatera befintligt id
            $book->update($request->all());

            //Returnerar uppdaterad post
            return $book;

        } else {
            //Returnera 404 felmeddelande om ID ej finns
            return response()->json(
                ["Boken finns inte!"
            ], 404);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $book = Book::find($id);

        //Kontroll om ID finns i databasen.
        if($book != null) {
            //Om ID finns så raderas data och bekräftelsemeddelande skickas
            $book->delete();
            return response()->json([
                "Boken är raderad!"
            ]);
        } else {
            //Om ID inte finns så blir svaret 404 not found
            return response()->json([
                "Boken finns inte"
            ], 404);
        }
    }
}
