<?php

//use Illuminate\Support\Facades\DB;

DB::connection('foo')->select();
DB::select('select * from users where active = ?', [1]);
DB::select('select * from users where id = :id', ['id'=>1]);
DB::insert('insert into users(id, name) valuse(?, ?)', [1, 'Dayle']);
DB::statement('drop table users');//无返回值
DB::unprepared('update user set votes = 100 where name = "Dries"');//不使用预处理

DB::transaction(function(){

    DB::table()->update();
    DB::table()->delete();

}, 5);

DB::beginTransaction();
DB::rollBack();
DB::commit();

DB::table()->get();
DB::table()->where()->first();
DB::table()->where()->value('id');
DB::table()->find($id);
DB::table()->pluck('title');
DB::table()->pluck('value', 'key');
DB::table()->orderBy('id')->chunk(100, function($record){
    foreach($record as $item){
        if($item->id == 100) return false;//终止
    }
});

DB::table()->where()->chunkById(100, function($record){
    foreach($record as $item){

    }
});

DB::table()->count();
DB::table()->max('price');
DB::table()->avg('price');
DB::table()->where()->exists();
DB::table()->where()->doesntExist();
DB::table()->select('name', 'user_email as email')->get();
DB::table()->distinct()->get();
DB::table()->select()->addSelect()->get();
DB::table()->select(DB::raw('count(*) as ucount, status'))->where()->groupBy()->get();
DB::table()->selectRaw('price * ? as tax_price', [1.08])->get();
DB::table()->whereRaw('price < if(state = "TX", ?, 100, [200])')->get();
DB::table()->select()->groupByRaw()->havingRaw();
DB::table()->orderByRaw('update_at - create_at desc')->get();
DB::table()->join('table', 't.id', '=', 'b.tid')->get();
DB::table()->leftJoin()->get();
DB::table()->rightJoin()->get();
DB::table()->crossJoin()->get();
DB::table('user')->join('school', function($join){
    $join->on('school.uid', '=', 'user.id')->orOn();
})->get();

DB::table()->join('table', function($join){
    $join->on()->where();
})->get();

DB::table()->joinSub(DB::table()->select(), 'tablename', function($join){
    $join->on('user.id', '=', 'tablename.user_id');

})->get();


DB::table('user')->whereNull('last_name')->union(DB::table('user')->whereNull('first_name'))->get();
DB::table()->where('name', 'like', 'T%');
DB::table()->where('name', '<>', 100);
DB::table()->where([
    ['status', '=', 1],
    ['name', '<>', 'tom']
]);
DB::table()->where()->orWhere('name', 'join')
DB::table()->where('votes', '>', 100)->orWhere(function($query){
    $query->where()->where();
});//select * from users where votes > 100 or (subwhere...)
DB::table()->whereBetween('votes', [1, 100])->whereNotBetween();
DB::table()->whereIN('id', [1,2,3])->whereNotIn()->orWhereIn();
















