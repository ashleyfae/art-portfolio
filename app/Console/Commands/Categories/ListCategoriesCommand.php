<?php

namespace App\Console\Commands\Categories;

use App\Models\Category;
use Illuminate\Console\Command;

class ListCategoriesCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'categories:list';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Lists all categories';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        dd(Category::query()->orderBy('name')->get()->toArray());
    }
}
