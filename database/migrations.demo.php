<?php
/**
 * 创建表：Schema::create('table')
 * php artisan make:migration create_users_table --create=users
 *
 * 使用表：Schema::table('table')
 * php artisan make:migration add_votes_to_users_table --table=users

 * 转储且删除(--prune)原有迁移文件
 * php artisan schema:dump --prune
 *
 * 运行
 * php artisan migrate --force
 *
 * 回滚指定数量的迁移
 * php artisan migrate:rollback --step=5
 *
 * 回滚上一次迁移
 * php artisan migrate:reset
 *
 * 刷新所有迁移后，更新未有的迁移
 * php artisan migrate:refresh --seed
 *
 * php artisan migrate:refresh --step=5
 *
 * 刷新当前已有的迁移，
 * php artisan migrate:fresh
 *
 * 刷新当前已有的迁移后，更新未有的迁移。
 * php artisan migrate:fresh --seed
 *
 */
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration {
    /**
     * Run the migrations.
     * @return void
     */
    public function up(){
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
        });

        //如果不存在'users'表则执行
        if (Schema::hasTable('users')) {

        }
        //如果不存在'users','email'列则执行
        if (Schema::hasColumn('users', 'email')) {

        }

        //连接其他数据库
        Schema::connection('foo')->create('users', function (Blueprint $table) {
            $table->id();
            $table->engine = 'InnoDB';	//指定表存储引擎
            $table->charset = 'utf8mb4';	//指定数据表的默认字符集
            $table->collation = 'utf8mb4_unicode_ci';	//指定数据表默认的排序规则 (MySQL)。
            $table->temporary();	//创建临时表 (不支持 SQL Server)
        });

        Schema::rename($from, $to);
        Schema::drop('users');
        Schema::dropIfExists('users');


        $table->id();   //$table->bigIncrements('id') 的别名
        $table->foreignId('user_id');	//$table->unsignedBigInteger('user_id') 的别名
        $table->bigIncrements('id');	//递增 ID
        $table->bigInteger('votes');
        $table->binary('data');
        $table->boolean('confirmed');
        $table->char('name', 100);
        $table->date('created_at');
        $table->dateTime('created_at', 0);
        $table->dateTimeTz('created_at', 0);
        $table->decimal('amount', 8, 2);
        $table->double('amount', 8, 2);
        $table->enum('level', ['easy', 'hard']);
        $table->float('amount', 8, 2);
        $table->geometry('positions');
        $table->geometryCollection('positions');
        $table->increments('id');
        $table->integer('votes');
        $table->ipAddress('visitor');
        $table->json('options');
        $table->jsonb('options');
        $table->lineString('positions');
        $table->longText('description');
        $table->macAddress('device');
        $table->mediumIncrements('id');
        $table->mediumInteger('votes');
        $table->mediumText('description');
        $table->morphs('taggable');	//加入递增 UNSIGNED BIGINT 类型的 taggable_id 与字符串类型的 taggable_type
        $table->uuidMorphs('taggable');	//相添加一个 CHAR (36) 类型的 taggable_id 字段和 VARCHAR (255) UUID 类型的 taggable_type
        $table->multiLineString('positions');
        $table->multiPoint('positions');
        $table->multiPolygon('positions');
        $table->nullableMorphs('taggable');	//添加一个可以为空版本的 morphs() 字段.
        $table->nullableUuidMorphs('taggable');	//添加一个可以为空版本的 uuidMorphs() 字段
        $table->nullableTimestamps(0);	//timestamps() 方法的别名
        $table->point('position');
        $table->polygon('positions');
        $table->rememberToken();	//添加一个允许空值的 VARCHAR (100) 类型的 remember_token 字段
        $table->set('flavors', ['strawberry', 'vanilla']);
        $table->smallIncrements('id');
        $table->smallInteger('votes');
        $table->softDeletes('deleted_at', 0);	//为软删除添加一个可空的 deleted_at 字段
        $table->softDeletesTz('deleted_at', 0);	//为软删除添加一个可空的 带时区的 deleted_at 字段
        $table->string('name', 100);
        $table->text('description');
        $table->time('sunrise', 0);
        $table->timeTz('sunrise', 0);//指定位数带时区的 TIME
        $table->timestamp('added_on', 0);
        $table->timestampTz('added_on', 0);	//指定位数带时区的 TIMESTAMP
        $table->timestamps(0);	//可空的 TIMESTAMP 类型的 created_at 和 updated_at
        $table->timestampsTz(0);//指定时区的可空的 TIMESTAMP 类型的 created_at 和 updated_at
        $table->tinyIncrements('id');
        $table->tinyInteger('votes');
        $table->unsignedBigInteger('votes');
        $table->unsignedDecimal('amount', 8, 2);
        $table->unsignedInteger('votes');
        $table->unsignedMediumInteger('votes');
        $table->unsignedSmallInteger('votes');
        $table->unsignedTinyInteger('votes');
        $table->uuid('id');
        $table->year('birth_year');


        //->after('column')	将此字段放置在其它字段 「之后」 (MySQL)
        //->autoIncrement()	将 INTEGER 类型的字段设置为自动递增的主键
        //->charset('utf8mb4')	指定一个字符集 (MySQL)
        //->collation('utf8mb4_unicode_ci')	指定排序规则 (MySQL/PostgreSQL/SQL Server)
        //->comment('my comment')	为字段增加注释 (MySQL/PostgreSQL)
        //->default($value)	为字段指定 “默认” 值
        //->first()	将此字段放置在数据表的 「首位」 (MySQL)
        //->from($integer)	给自增字段设置一个起始值 (MySQL / PostgreSQL)
        //->nullable($value = true)	此字段允许写入 NULL 值（默认情况下）
        //->storedAs($expression)	创建一个存储生成的字段 (MySQL)
        //->unsigned()	设置 INTEGER 类型的字段为 UNSIGNED (MySQL)
        //->useCurrent()	将 TIMESTAMP 类型的字段设置为使用 CURRENT_TIMESTAMP 作为默认值
        //->virtualAs($expression)	创建一个虚拟生成的字段 (MySQL)
        //->generatedAs($expression)	使用指定的序列生成标识列（PostgreSQL）
        //->always()	定义序列值优先于标识列的输入 (PostgreSQL)

        //修饰字段功能，依赖 composer require doctrine/dbal
        Schema::table('users', function (Blueprint $table) {
            $table->string('email')->nullable();//允许为空
            $table->json('movies')->default(new Expression('(JSON_ARRAY())'));
            $table->string('name', 50)->nullable()->change();; //字段的长度修改为 50，且允许为空
            $table->renameColumn('from', 'to');
            $table->dropColumn('votes');
            $table->dropColumn(['votes', 'avatar', 'location']);

            //可用的命令别名
            $table->dropMorphs('morphable');	//删除 morphable_id 和 morphable_type 字段
            $table->dropRememberToken();	//删除 remember_token 字段
            $table->dropSoftDeletes();	//删除 deleted_at 字段
            $table->dropSoftDeletesTz();	//dropSoftDeletes() 方法的别名
            $table->dropTimestamps();	//删除 created_at 和 updated_at 字段
            $table->dropTimestampsTz();	//dropTimestamps() 方法别名

            $table->string('email')->unique();
            $table->unique('email');
            $table->index(['account_id', 'created_at']);
            $table->unique('email', 'unique_email');

            $table->primary('id');	//添加主键
            $table->primary(['id', 'parent_id']);	//添加复合键
            $table->index('state');	//添加普通索引
            $table->spatialIndex('location');	//添加空间索引
            $table->renameIndex('from', 'to'); //重命名索引

            $table->dropPrimary('users_id_primary');	//从 users 表中删除主键
            $table->dropUnique('users_email_unique');	//从 users 表中删除 unique 索引
            $table->dropIndex('geo_state_index');	//从 geo 表中删除基本索引
            $table->dropSpatialIndex('geo_location_spatialindex');	//从 geo 表中删除空间索引

        });

        Schema::table('geo', function (Blueprint $table) {
            $table->dropIndex(['state']); // 删除 'geo_state_index' 索引
        });

        //外键约束
        Schema::table('posts', function (Blueprint $table) {

            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');

            $table->foreignId('user_id')->constrained(); // constrained 使用约定来确定所引用的表名和列名
            $table->foreignId('user_id')->constrained('users');

            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->nullable()->constrained();

            //删除外键
            $table->dropForeign('posts_user_id_foreign');
            $table->dropForeign(['user_id']);

            $table->softDeletes();
            $table->dropSoftDeletes();
        });


        //开启或关闭外键约束
        Schema::enableForeignKeyConstraints();
        Schema::disableForeignKeyConstraints();

    }

    /**
     * Reverse the migrations.
     * @return void
     */
    public function down(){
        Schema::dropIfExists('users');
    }

}
