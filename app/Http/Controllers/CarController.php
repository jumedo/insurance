<?php

namespace App\Http\Controllers;

use App\Car;
use App\Owner;
use App\User;
use Illuminate\Http\Request;

class CarController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'isAdmin']);
    }

    function CarList()
    {
        return view('cars', ['cars' => Car::all()]);
    }

    public function addCar()
    {
        return view('addCar',
            ['owners' => Owner::all(),
                'users' => User::all()
            ]);
    }

    public function insertCar(Request $request)
    {
        $this->validate($request, [
            'reg_number'=> 'min:3|max:10|unique:cars,reg_number'
        ]
//            ,
//            [
//                'reg_number.unique' => "Toks automobilis jau yra !"
//            ]
        );
        $car = new Car();
        $car->reg_number = $request->reg_number;
        $car->brand = $request->brand;
        $car->model = $request->model;
        $car->owner_id = $request->owner_id;
        $car->user_id = $request->user_id;
        $car->save();

        return redirect()->route('carList'
        );
    }


    public function editCar($id)
    {
        $car = Car::find($id);
        return view('editCar', ['car' => $car, 'owners' => Owner::all(), 'users' => User::all()]);
    }

    public function updateCar($id, Request $request)
    {
        $this->validate($request, [
            'reg_number'=> 'min:3|max:10|unique:cars,reg_number'
        ]
//            ,
//            [
//                'reg_number.unique' => "Toks reg_number automobilis jau yra !"
//            ]
        );
        $car = Car::find($id);
        $car->reg_number = $request->reg_number;
        $car->brand = $request->brand;
        $car->model = $request->model;
        $car->owner_id = $request->owner_id;
        $car->user_id = $request->user_id;
        $car->save();

        return redirect()->route('carList');
    }

    public function deleteCar($id)
    {
        $car = Car::find($id);
        $car->delete();
        return redirect()->route('carList');
    }
}
