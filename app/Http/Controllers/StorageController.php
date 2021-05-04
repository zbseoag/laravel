<?php
/**
 * 文件存储
 */
namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\File;

class StorageController extends Controller {


    public function config(){

        $file = 'config/filesystems.php';
        $command = ['php artisan storage:link' => 'The [/e/laravel/public/storage] link has been connected to [/e/laravel/storage/app/public]'];
        $path = asset('storage/file.txt');

        $config = [
            'links' => [
                public_path('storage') => storage_path('app/public'),
                public_path('images') => storage_path('app/images'),
            ],

            'local' => [
                'driver' => 'local',
                'root' => storage_path('app'),
                'permissions' => [
                    'file' => [
                        'public' => 0664,
                        'private' => 0600,
                    ],
                    'dir' => [
                        'public' => 0775,
                        'private' => 0700,
                    ],
                ],
            ],

            's3' => [
                'driver' => 's3',

                // Other Disk Options...

                'cache' => [
                    'store' => 'memcached',
                    'expire' => 600,
                    'prefix' => 'cache-prefix',
                ],
            ],

            'public' => [
                'driver' => 'local',
                'root' => storage_path('app/public'),
                'url' => env('APP_URL').'/storage',
                'visibility' => 'public',
            ],
        ];

        //测试
        Storage::disk('local')->put('file.txt', '这是文件内容！');
    }

    public function used(){

        Storage::put('avatars/1', 'Conetents');
        Storage::disk('s3')->put('avatars/1', 'Conetents');
        Storage::get('file.jpg');
        Storage::disk()->exists();
        Storage::disk()->missing();
        Storage::download('file.jpg', $name, $header);
        Storage::url('file.jpg');
        Storage::path('file.jpg');
        Storage::temporaryUrl('file.jpg', now()->addMinutes(10));//临时url 10分钟有效期
        Storage::temporaryUrl('file.jpg', now()->addMinutes(10), ['ResponseContentType'=>'application/octet-stream']);
        Storage::size('file.jpg');
        Storage::lastModified('file.jpg');
        Storage::put('file.jpg', 'content');
        Storage::put('file.jpg', 'content');
        Storage::putFile('photos', new File('/path/to/photo'));
        Storage::putFileAs('photos', new File('/path/to/photo'), 'photo.jpg');
        Storage::putFile('photos', new File('/path/to/file'), 'public'); //可见性
        Storage::prepend('file.log', '在开头追加内容');
        Storage::append('file.log', 'append data');
        Storage::copy('file', 'newfile');
        Storage::move('file', 'newfile');
        request()->file('filename')->store('fielname');
        Storage::putFile('file', request()->file('filename'));
        request()->file()->storeAs('filename', request()->user()->id);
        Storage::putFileAs('file', request()->file('filename'), request()->user()->id);
        //League\Flysystem\Util::normalizePath 处理路径
        request()->file('filename')->storeAs('file', request()->user()->id, 's3');
        request()->file()->getClientOriginalName();
        request()->file()->extension();
        Storage::put('file.jpg', 'content', 'public');
        Storage::getVisibility('file.jpg');
        Storage::setVisibility('file.jpg', 'public');

        request()->file('avatar')->storePublicly('avatars', 's3');
        request()->file('avatar')->storePubliclyAs('avatars',  request()->user()->id, 's3');

        Storage::delete('file.jpg');
        Storage::delete(['file.jpg', 'file2.jpg']);
        Storage::disk('s3')->delete('folder_path/file_name.jpg');
        Storage::files('dir');
        Storage::allFiles('dir');//当前目录和所有子目录文件
        Storage::directories('dir');//获取目录
        Storage::allDirectories('dir');
        Storage::makeDirectory('dir');
        Storage::deleteDirectory('dir');



    }
}
