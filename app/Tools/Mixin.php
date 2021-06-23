<?php
namespace App\Tools;

\Illuminate\Database\Query\Builder::mixin(new class {

    public function sql()
    {
        return function(){
            return array_reduce($this->getBindings(), function($sql, $binding){
                return preg_replace('/\?/', is_string($binding) ? "'".$binding."'"  : $binding, $sql, 1);
            }, $this->toSql());
        };
    }

});


\Illuminate\Database\Eloquent\Builder::mixin(new class{

    public function sql()
    {
        return function(){$this->getQuery()->sql();};
    }

    public function dd()
    {
        return function(){dd($this->getQuery()->sql());};
    }

    public function dump()
    {
        return function(){ dump($this->getQuery()->sql()); };
    }

});




