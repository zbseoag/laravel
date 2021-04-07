<?php
namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;

class DbController extends Controller{

    public function index(){

        $users = DB::connection('foo')->select('select * from users where active = ?', [1]);
        DB::connection()->getPdo();

        $record = DB::select('select * from users where active = ?', [1]);
        $record = DB::select('select * from users where id = :id', ['id' => 1]);

        DB::insert('insert into users (id, name) values (?, ?)', [1, 'Dayle']);
        $affected = DB::update('update users set votes = 100 where name = ?', ['John']);
        $deleted = DB::delete('delete from users');
        DB::statement('drop table users');
        DB::unprepared('update users set votes = 100 where name = "Dries"');
        DB::unprepared('create table a (col varchar(1) null)'); //隐式提交

        DB::transaction(function () {
            DB::table('users')->update(['votes' => 1]);
            DB::table('posts')->delete();
        }, 5);

        DB::beginTransaction();
        DB::rollBack();
        DB::commit();



        $users = DB::table('users')->get();
        $user = DB::table('users')->where('name', 'John')->first();
        $email = DB::table('users')->where('name', 'John')->value('email');

        $user = DB::table('users')->find(3);
        $titles = DB::table('roles')->pluck('title');
        $select = DB::table('roles')->pluck('id', 'name');

        DB::table('users')->orderBy('id')->chunk(100, function($users){
            foreach($users as $user){

            }
        });

        DB::table('users')->orderBy('id')->chunk(100, function($users){
            return false;//终止执行
        });


        DB::table('users')->where('active', false)->chunkById(100, function ($users) {
            foreach($users as $user) {
                DB::table('users')->where('id', $user->id)->update(['active' => true]);
            }
        });

        $users = DB::table('users')->count();
        $price = DB::table('orders')->max('price');
        $price = DB::table('orders')->where('finalized', 1)->avg('price');

        DB::table('orders')->where('finalized', 1)->exists();
        DB::table('orders')->where('finalized', 1)->doesntExist();

        $users = DB::table('users')->select('name', 'email as user_email')->get();
        $users = DB::table('users')->distinct()->get();

        $users = DB::table('users')->select('name')->addSelect('age')->get();

        $users = DB::table('users')
            ->select(DB::raw('count(*) as user_count, status'))
            ->where('status', '<>', 1)
            ->groupBy('status')
            ->get();


        $orders = DB::table('orders')
            ->selectRaw('price * ? as price_with_tax', [1.0825])
            ->get();

        $orders = DB::table('orders')
            ->whereRaw('price > IF(state = "TX", ?, 100)', [200])
            ->get();

        $orders = DB::table('orders')
            ->select('department', DB::raw('SUM(price) as total_sales'))
            ->groupBy('department')
            ->havingRaw('SUM(price) > ?', [2500])
            ->get();

        $orders = DB::table('orders')->orderByRaw('updated_at - created_at DESC')->get();


        $users = DB::table('users')
            ->join('contacts', 'users.id', '=', 'contacts.user_id')
            ->join('orders', 'users.id', '=', 'orders.user_id')
            ->select('users.*', 'contacts.phone', 'orders.price')
            ->get();

        $users = DB::table('users')->leftJoin('posts', 'users.id', '=', 'posts.user_id')->get();
        $users = DB::table('users')->rightJoin('posts', 'users.id', '=', 'posts.user_id')->get();

        $sizes = DB::table('sizes')->crossJoin('colors')->get();

        DB::table('users')->join('contacts', function ($join) {
            $join->on('users.id', '=', 'contacts.user_id')->orOn();
        })->get();


        DB::table('users')->join('contacts', function ($join) {
                $join->on('users.id', '=', 'contacts.user_id')->where('contacts.user_id', '>', 5);
        })->get();

        //子查询
        $latestPosts = DB::table('posts')->select('user_id', DB::raw('MAX(created_at) as last_post_created_at'))
            ->where('is_published', true)
            ->groupBy('user_id');

        $users = DB::table('users')->joinSub($latestPosts, 'latest_posts', function($join){
                $join->on('users.id', '=', 'latest_posts.user_id');
        })->get();

        //union
        $first = DB::table('users')->whereNull('first_name');
        $users = DB::table('users')->whereNull('last_name')->union($first)->get();

        $users = DB::table('users')->where('votes', 100)->get();
        $users = DB::table('users')->where('votes', '>=', 100)->get();
        $users = DB::table('users')->where('votes', '<>', 100)->get();
        $users = DB::table('users')->where('name', 'like', 'T%')->get();

        $users = DB::table('users')->where([ ['status', '=', '1'], ['subscribed', '<>', '1'] ])->get();
        $users = DB::table('users')->where('votes', '>', 100)->orWhere('name', 'John')->get();

        // SQL语句: select * from users where votes > 100 or (name = 'Abigail' and votes > 50)
        $users = DB::table('users')->where('votes', '>', 100)->orWhere(function($query){
                $query->where('name', 'Abigail')->where('votes', '>', 50);
        })->get();

        $users = DB::table('users')->whereBetween('votes', [1, 100])->get();
        $users = DB::table('users')->whereNotBetween('votes', [1, 100])->get();

        //如果要在查询中添加大量整数绑定，则可以使用 whereIntegerInRaw 或  whereIntegerNotInRaw 方法来大大减少内存使用。
        $users = DB::table('users')->whereIn('id', [1, 2, 3])->get();
        $users = DB::table('users')->whereNotIn('id', [1, 2, 3])->get();

        $users = DB::table('users')->whereNull('updated_at')->get();
        $users = DB::table('users')->whereNotNull('updated_at')->get();
        $users = DB::table('users')->whereDate('created_at', '1989-01-09')->get();
        $users = DB::table('users')->whereYear('created_at', '1989')->get();
        $users = DB::table('users')->whereMonth('created_at', '01')->get();
        $users = DB::table('users')->whereDay('created_at', '09')->get();
        $users = DB::table('users')->whereTime('created_at', '=', '11:20:45')->get();

        $users = DB::table('users')->whereColumn('first_name', 'last_name')->get(); //比较两个字段的值是否相等
        $users = DB::table('users')->orWhereColumn('first_name', 'last_name')->get();
        $users = DB::table('users')->whereColumn('updated_at', '>', 'created_at')->get();

        $users = DB::table('users')->whereColumn([
            ['first_name', '=', 'last_name'],
            ['updated_at', '>', 'created_at'],
        ])->get();

        //select * from users where name = 'John' and (votes > 100 or title = 'Admin')
        $users = DB::table('users')->where('name', '=', 'John')->where(function($query){
            $query->where('votes', '>', 100)->orWhere('title', '=', 'Admin');
        })->get();


        //select * from users where exists (select 1 from orders where orders.user_id = users.id)
        $users = DB::table('users')->whereExists(function($query){
            $query->select(DB::raw(1))->from('orders')->whereRaw('orders.user_id = users.id');
        })->get();


        $users = User::where(function($query){
            $query->select('type')->from('membership')->whereColumn('user_id', 'users.id')->orderByDesc('start_date')->limit(1);
        }, 'ProValue')->get();

        //JSON Where 语句
        $users = DB::table('users')->where('options->language', 'en')->get();
        $users = DB::table('users')->where('preferences->dining->meal', 'salad')->get();
        $users = DB::table('users')->whereJsonContains('options->languages', 'en')->get();
        $users = DB::table('users')->whereJsonContains('options->languages', ['en', 'de'])->get();

        $users = DB::table('users')->whereJsonLength('options->languages', 0)->get();
        $users = DB::table('users')->whereJsonLength('options->languages', '>', 1)->get();


    }


    public function orderBy(){

        $users = DB::table('users')->orderBy('name', 'desc')->orderBy('email', 'asc')->get();
        $user = DB::table('users')->latest()->first(); //最新的,默认使用 created_at 列作为排序依据
        $user = DB::table('users')->oldest()->first();//最旧的

        $randomUser = DB::table('users')->inRandomOrder()->first();//随机排序

        $query = DB::table('users')->orderBy('name')->reorder()->get(); //清除排序
        $users = DB::table('users')->groupBy('account_id')->having('account_id', '>', 100)->get();
        $users = DB::table('users')->groupBy('first_name', 'status')->having('account_id', '>', 100)->get();

        $users = DB::table('users')->offset(10)->limit(5)->get();//跳过，并返回指定条数
        $users = DB::table('users')->skip(10)->take(5)->get();//同上

        $role = request()->input('role');
        $users = DB::table('users')->when($role, function ($query, $role){
                return $query->where('role_id', $role); //条件语句,定值在请求中存在的情况下才应用 where 语句
        })->get();


        //传递另一个闭包作为 when 方法的第三个参数。 该闭包会在第一个参数为 false 的情况下执行。为了说明如何使用这个特性
        $sortBy = null;
        $users = DB::table('users')->when($sortBy, function($query, $sortBy){
                return $query->orderBy($sortBy);
            }, function ($query) {
                return $query->orderBy('name'); //默认排序
        })->get();

    }

    public function insert(){

        DB::table('users')->insert(['email' => 'john@example.com', 'votes' => 0]);

        DB::table('users')->insert([
            ['email' => 'taylor@example.com', 'votes' => 0],
            ['email' => 'dayle@example.com', 'votes' => 0],
        ]);

        //记录插入数据库时将忽略重复记录错误
        DB::table('users')->insertOrIgnore([
            ['id' => 1, 'email' => 'taylor@example.com'],
            ['id' => 2, 'email' => 'dayle@example.com'],
        ]);

        $id = DB::table('users')->insertGetId(
            ['email' => 'john@example.com', 'votes' => 0]
        );

    }

    public function update(){

        $affected = DB::table('users')->where('id', 1)->update(['votes' => 1]);

        DB::table('users')->updateOrInsert(
            ['email' => 'john@example.com', 'name' => 'John'],//插入的记录
            ['votes' => '2']//或者更新的数据
        );

        $affected = DB::table('users')->where('id', 1)->update(['options->enabled' => true]);//更新 JSON 字段

        //自增与自减，当你使用模型中的 increment 和 decrement 方法时，会触发 updating 和 updated 模型事件。直接使用  increment 和 decrement，不会触发模型事件。
        DB::table('users')->increment('votes');
        DB::table('users')->increment('votes', 5);
        DB::table('users')->decrement('votes');
        DB::table('users')->decrement('votes', 5);
        DB::table('users')->increment('votes', 1, ['name' => 'John']);//自增指定记录

    }

    public function delete(){

        DB::table('users')->delete();
        DB::table('users')->where('votes', '>', 100)->delete();
        DB::table('users')->truncate();//截断表，主键自增从1开始

        DB::table('users')->where('votes', '>', 100)->sharedLock()->get();
        DB::table('users')->where('votes', '>', 100)->lockForUpdate()->get();

        //调试
        DB::table('users')->where('votes', '>', 100)->dd();
        DB::table('users')->where('votes', '>', 100)->dump();

    }

    public function paginate(){

        //无法高效地执行使用groupBy语句的分页操作。如果你需要对使用了groupBy的结果集分页，建议你手动查询数据库并创建分页。
        $users = DB::table('users')->paginate(15);

        $users = DB::table('users')->simplePaginate(15);//下一页 和 上一页
        $users = User::where('votes', '>', 100)->paginate(15);

        //手动创建分页 Illuminate\Pagination\Paginator 或 Illuminate\Pagination\LengthAwarePaginator

        /*
         *  显示分页
            <div class="container">
            @foreach ($users as $user)
                {{ $user->name }}
            @endforeach
            </div>
            {{ $users->links() }}
         */

        User::paginate(15)->withPath('custom/url');//自定义分页url
        $users->appends(['sort' => 'votes'])->links();

        $users->withQueryString()->links();//把所有的查询参数值添加到分页链接
        $users->fragment('foo')->links();//添加锚点
        $users->onEachSide(5)->links();//默认情况下，主分页链接的每侧显示三个链接。

        //分页器类实现了 Illuminate\Contracts\Support\Jsonable 接口契约，提供了 toJson 方法，所以可以方便的将分页结果转换为 JSON 。
        Route::get('users', function () {
            return App\Models\User::paginate();
        });

        $pagedata = '
        {
           "total": 50,
           "per_page": 15,
           "current_page": 1,
           "last_page": 4,
           "first_page_url": "http://laravel.app?page=1",
           "last_page_url": "http://laravel.app?page=4",
           "next_page_url": "http://laravel.app?page=2",
           "prev_page_url": null,
           "path": "http://laravel.app",
           "from": 1,
           "to": 15,
           "data":[{ // Result Object } ]
        }';

        //自定义分页视图
        $paginator->links('view.name');
        $paginator->links('view.name', ['foo' => 'bar']);

        //php artisan vendor:publish --tag=laravel-pagination
        //resources/views/vendor/pagination 目录中放置这些视图

        $paginator->count(); //获取当前页数据的数量。
        $paginator->currentPage();//获取当前页页码
        $paginator->firstItem();//获取结果集中第一条数据的结果编号。
        $paginator->getOptions();//获取分页器选项。
        $paginator->getUrlRange($start, $end);//创建分页 URL 的范围。
        $paginator->hasPages();//是否有多页。
        $paginator->hasMorePages();//是否有更多页。
        $paginator->items();//获取当前页的所有项。
        $paginator->lastItem();//获取结果集中最后一条数据的结果编号。
        $paginator->lastPage();//获取最后一页的页码。(在simplePaginate无效)。
        $paginator->nextPageUrl();//获取下一页的 URL。
        $paginator->onFirstPage();//当前页是否为第一页。
        $paginator->perPage();//每页的数据条数。
        $paginator->previousPageUrl();//获取前一页的 URL。
        $paginator->total();//数据总数（在simplePaginate无效）。
        $paginator->url($page);//获取指定页的 URL。
        $paginator->getPageName();//获取分页的查询字符串变量。
        $paginator->setPageName($name);//设置分页的查询字符串变量。


    }


}
