<?php 

namespace App\Http\Traits;

use Illuminate\Database\Query\Builder as QueryBuilder;
use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
use Illuminate\Database\Eloquent\Model;

trait CanLoadRelationships {
    /**
     * @param Model|QueryBuilder|EloquentBuilder $for
     *      
     * @return boolean
     */
    public function loadRelationships(Model|QueryBuilder|EloquentBuilder $for, ?array $relations = null): Model|QueryBuilder|EloquentBuilder {
        // if not passed to function relations will be populated by object's parameter or become an empty array
        $relations = $relations ?? $this->relations ?? [];

        foreach($relations as $relation) {
            // if instance of Model, $for will not have the 'with' method available
            $for->when(
                $this->shouldIncludeRelation($relation),
                fn($q) => $for instanceof Model ? $for->load($relation) : $q->with($relation)
            );
        }

        return $for;
    }

    protected function shouldIncludeRelation(string $relation): bool {
        $include = request()->query('include');

        if(!$include) {
            return false;
        }

        $relations = array_map('trim', explode(',', $include));

        return in_array($relation, $relations);
    }
}