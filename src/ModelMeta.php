<?php

namespace Spatie\ModelReflection;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Spatie\ModelReflection\Attributes\Attribute;
use Spatie\ModelReflection\Attributes\AttributeFinder;
use Spatie\ModelReflection\Relations\RelationFinder;

class ModelMeta
{
    /**
     * @param class-string<Model>|Model $model
     *
     * @return self
     */
    public static function forModel(string|Model $model): self
    {
        if (is_string($model)) {
            $model = new $model;
        }

        return (new self(
            $model::class,
            $model->getConnection()->getName(),
            $model->getConnection()->getTablePrefix().$model->getTable(),
            RelationFinder::forModel($model),
            AttributeFinder::forModel($model),
        ));
    }

    public function __construct(
        public string $class,
        public string $connectionName,
        public string $tableName,
        public Collection $relations,
        public Collection $attributes,
    )
    {

    }
}
