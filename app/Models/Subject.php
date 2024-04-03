<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Subject extends Model
{
    use HasFactory;

    protected $table = 'subjects';

     /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'class_id',
    ];

    /**
     * Define the many-to-many relationship with the Language model.
     */
    public function languages()
    {
        return $this->belongsToMany(Language::class);
    }

    public static function getSubjectsFilterdData($filter = [], $csv = false){
       $orderColumnArray = [
            0 => 'subjects.name', 
            1 => 'classes.name',
            2 => 'languages.languag_name'  
        ];

        $query = DB::table('language_subject')
            ->select([
                "subjects.name as name", 
                "classes.name as class",
                "languages.languag_name as language",
            ])
            ->leftJoin('subjects', 'subjects.id', '=', 'language_subject.subject_id')
            ->leftJoin('classes', 'classes.id', '=', 'subjects.class_id')
            ->leftJoin('languages', 'languages.id', '=', 'language_subject.language_id');

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
        $totalRecords = $query->count();

        /** Order by column and direction */
        if (isset($filter['order'][0]['column']) && isset($orderColumnArray[$filter['order'][0]['column']]) && isset($filter['order'][0]['dir'])) {
            $query->orderBy($orderColumnArray[$filter['order'][0]['column']], $filter['order'][0]['dir']);
        } else {
            $query->orderBy($orderColumnArray[0], 'asc');
        }

        /** Set the pagination length */
        $formatUserData = $query->when(isset($filter['start']) && isset($filter['length']), function ($query) use ($filter) {
            return $query->skip($filter['start'])->take($filter['length']);
        })->get();

        /** Making final array */
        $finalArray=[];
        foreach ($formatUserData as $key => $value) {
            $finalArray[$key]['name'] = $value->name;
            $finalArray[$key]['class'] = $value->class;
            $finalArray[$key]['language'] = $value->language;
        }

        /** Defining final array for datatable */
        return [
            'data' => $finalArray,
            'recordsTotal' => $totalRecords, // Use count of formatted data for total records
            'recordsFiltered' => $totalRecords, // Use total records from the query
        ];
    }
}
