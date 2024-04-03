<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Students extends Model
{
    use HasFactory;
    
    public function class(){
        return $this->belongsTo(Classes::class);
    }

    protected $table = 'students';

     /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'age',
        'image',
        'class_id',
        'roll_number',
    ];

    public static function getStudentFilterdData($filter = [], $csv = false){
        $orderColumnArray = [
            0 => 'students.name', 
            1 => 'students.age', 
            2 => 'students.image', 
            3 => 'classes.name', 
            4 => 'students.roll_number'
        ];

        $query = self::query()->select([
            "students.name as name", 
            "students.age as age", 
            "students.image as image", 
            "classes.name as class", 
            "students.roll_number as roll_number",
        ])  
        ->leftJoin('classes', 'classes.id', '=', 'students.class_id');

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
                $finalArray[$key]['name'] = $value->name;
                $finalArray[$key]['age'] = $value->age;
                $finalArray[$key]['image'] = '<img src="'.asset('storage/app/student_images/' . $value->image).'" alt="'.$value->name.'" style="max-width: 100px;">';
                $finalArray[$key]['class'] = $value->class;
                $finalArray[$key]['roll_number'] = $value->roll_number;
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
