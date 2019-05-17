<?php

namespace Bhushanm\Laraman\Models;

use Illuminate\Database\Eloquent\Model;

use Bhushanm\Laraman\Traits\LocalScopes;

class Scope extends Model
{
	use LocalScopes;

    /**
     * Add one to many relationship between Scope and Version model through pivot(scope_version table).
     * 
     * @return QueryBuilder
     */
    public function versions(){
    	return $this->belongsToMany('Bhushanm\Laraman\Models\Version')->wherePivot('is_active', 1)->where('versions.is_active', 1);
    }

    /**
     * Generate routes using Scope & Version relationship.
     *
     * @return void
     */
    public static function  generateRoutes(){
    	$scopes = 	self::active()->has('versions')->with(['versions'])->where(function($query){
            $query->where('portal_id', config('portal.id'))->orWhereNull('portal_id');
        })->get();
    	
		foreach($scopes as $objScope){
			$strRoute 		=	$objScope->slug;
			$strResourceAction 	= 	$objScope->resource_action;
			$strMiddleware 	= 	$objScope->middleware;
			
			if(!(empty($strRoute) || empty($strResourceAction))) {
				$strRouteVerb 	= 	empty($objScope->http_verb) ? 'get' : strtolower($objScope->http_verb);
				foreach($objScope->versions as $objVersion){
					$strConfigFile = empty($objVersion->config_file)?'0':$objVersion->config_file;
					\Route::namespace($objVersion->controller_namespace)->prefix($objVersion->route_prefix)->group(function() use ($strRouteVerb, $strRoute, $strResourceAction, $strMiddleware, $objScope, $objVersion, $strConfigFile){
						$arrMiddleware = removeEmptyArrayElement(explode(',', $objVersion->middleware . ',' . $strMiddleware));
						if(!$objScope->is_open){
							array_unshift($arrMiddleware, 'auth:api', 'scopes:' .config('portal.id', 0) .',' .$objScope->name);
						}
						\Route::$strRouteVerb($strRoute, $strResourceAction)->middleware($arrMiddleware)->name($objScope->name . '.' . $objVersion->id .'.' .$strConfigFile);
					});
				}
			}
		}
    }
}
