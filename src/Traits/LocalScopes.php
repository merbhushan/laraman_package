<?php 
namespace Bhushanm\Laraman\Traits;

trait LocalScopes
{
    /*
    |--------------------------------------------------------------------------
    | LocalScopes Trait
    |--------------------------------------------------------------------------
    |
    | This traits implements some common scopes which can be used in any model to filter
    | the result set.
    |   - Active
    |   - Inactive
    |   - For given Primary Key(s)
    */

    /**
     * Scope a query to only include active resource(s) only.
     * 
     * @param  \Illuminate\Database\Eloquent\Builder    $objQuery    - Query object
     * @return \Illuminate\Database\Eloquent\Builder               
     */
    public function scopeActive($objQuery){
        return $objQuery->where('is_active', 1);
    }

    /**
     * Scope a query to only include active resource(s) only.
     * 
     * @param  \Illuminate\Database\Eloquent\Builder    $objQuery    - Query object
     * @return \Illuminate\Database\Eloquent\Builder               
     */
    public function scopeInactive($objQuery){
        return $objQuery->where('is_active', 0);
    }

    /**
     * Scope a query to only include resource of given id only.
     * 
     * @param  \Illuminate\Database\Eloquent\Builder    $objQuery   - Query object
     * @param   integer                                 $intId      - Integer Primary Key of any resource(Not composite key).
     * @return \Illuminate\Database\Eloquent\Builder               
     */
    public function scopeId($objQuery, $intId){
        return $objQuery->where('id', $intId);
    }

    /**
     * Scope a query to only include resource(s) of given ids only.
     * 
     * @param  \Illuminate\Database\Eloquent\Builder    $objQuery   - Query object
     * @param   array                                   $arrId      - Array of Integer Primary Key(s) of any resource(Not composite key).
     * @return \Illuminate\Database\Eloquent\Builder               
     */
    public function scopeIds($objQuery, array $arrId){
        return $objQuery->whereIn('id', $arrId);
    }
}