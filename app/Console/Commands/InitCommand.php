<?php

namespace App\Console\Commands;
use App\User;
// use DB;
use App\Hero as Hero;
use Illuminate\Console\Command;

class InitCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'init';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        InitCommand::get_or_create_admin();
        InitCommand::generate_heros();
    }

    public static function get_or_create_admin($name='admin'){
        if($user = User::where('name', $name)->first()){
            return $user;
        } else {
            $user = User::create([
                'name'      => $name,
                'email'     => $name . '@neven.com',
                'active'    => 1,
                // bcrypt hash for password
                'password'  => '$2a$10$AqQvOKVP0yHsGr/HnBAwueyna5J8skzTeNEXYYTdxD7RPWv99SHaG'
            ]);
            $user->admin = 1;
            $user->save();
        }
    }

    public static function generate_heros(){
        Hero::firstOrCreate([
            'video' => 'bee.webm',
            'image' => 'bee.jpg',
            'title_en' => '',
            'title_nb' => ''
        ]);

        Hero::firstOrCreate([
            'video' => 'lavander2.ogv',
            'image' => 'bee.jpg',
            'title_en' => '',
            'title_nb' => ''
        ]);

        Hero::firstOrCreate([
            'video' => 'mountain_clouds.webm',
            'image' => 'mountain_clouds.jpg',
            'title_en' => '',
            'title_nb' => ''
        ]);

        Hero::firstOrCreate([
            'video' => 'northern.webm',
            'image' => 'northern.jpg',
            'title_en' => '',
            'title_nb' => ''
        ]);

        Hero::firstOrCreate([
            'video' => 'riverlapse.webm',
            'image' => 'riverlapse.jpg',
            'title_en' => '',
            'title_nb' => ''
        ]);

        // DB::table('heroes')->insert([
            // ['video' => 'bee.webm', 'image' => 'bee.jpg',
            // 'title_en' => '', 'title_nb' => '' . ""],

            // ['video' => 'lavander2.ogv', 'image' => 'lavander.jpg',
            // 'title_en' => '', 'title_nb' => ''],

            // ['video' => 'mountain_clouds.webm', 'image' => 'mountain_clouds.jpg',
            // 'title_en' => '', 'title_nb' =>  ""],

            // ['video' => 'northern.webm', 'image' => 'northern.jpg',
            // 'title_en' => '', 'title_nb' => ""],

            // ['video' => 'riverlapse.webm', 'image' => 'riverlapse.jpg',
            // 'title_en' => '', 'title_nb' =>'']
        // ]);
    }
}
