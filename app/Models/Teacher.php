<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    use HasFactory;
    protected $table = 'teachers';

     /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'sex',
        'age',
        'name',
        'image',
    ];

    public static function getTeacherFilterdData($filter = [], $csv = false){
        $orderColumnArray = [
            0 => 'teachers.sex', 
            1 => 'teachers.age', 
            2 => 'teachers.name', 
            3 => 'teachers.image', 
        ];

        $query = self::query()->select([
            "sex", 
            "age", 
            "name", 
            "image",
        ]);  

        $totalRecords = $query->getQuery()->getCountForPagination();

        /** Search filter */
        if (isset($filter['search']['value']) && !empty($filter['search']['value'])) {
            $searchTerm = $filter['search']['value'];
            $query->where(function ($q) use ($searchTerm, $orderColumnArray) {
                foreach ($orderColumnArray as $column) {
                    $q->orWhere($column, 'LIKE', '%' . $searchTerm . '%');
                }
            });
        }


        /** Get total records count (without filtering) */
        if (isset($filter['order'][0]['column']) && isset($orderColumnArray[$filter['order'][0]['column']]) && isset($filter['order'][0]['dir'])) {
            /** Order by column and direction */
            $query->orderBy($orderColumnArray[$filter['order'][0]['column']], $filter['order'][0]['dir']);
        } else {
            $query->orderBy($orderColumnArray[0], 'asc');
        }

        /** Set the pagination lenght */
        $formatuserdata = $query->when(isset($filter['start']) && isset($filter['length']), function ($query) use ($filter) {
            return $query->skip($filter['start'])->take($filter['length']);
        })->get();
        
        $filteredRecords = $query->getQuery()->getCountForPagination();

        /** Making final array */
        $finalArray=[];
        if (isset($formatuserdata) && !empty($formatuserdata)) {
            foreach ($formatuserdata as $key => $value) {
                $finalArray[$key]['sex'] = $value->sex;
                $finalArray[$key]['age'] = $value->age;
                $finalArray[$key]['name'] = $value->name;
                $finalArray[$key]['image'] = '<img src="'.asset('storage/app/teacher_images' . $value->image).'" alt="'.$value->name.'" style="max-width: 100px;">';
            }
        }
        
        /** Defining final array for datatable */
        return [
            'data' => $finalArray,
            'recordsTotal' => $totalRecords, // Use count of formatted data for total records
            'recordsFiltered' => $filteredRecords, // Use total records from the query
        ];
    }
}
