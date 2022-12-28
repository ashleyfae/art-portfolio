<?php

namespace App\Console\Commands\Artwork;

use App\Actions\Artwork\DeleteArtwork;
use App\Models\Category;
use Illuminate\Console\Command;

class DeleteArtworkCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'artwork:delete {--category=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    public function __construct(protected DeleteArtworkByCategory $deleteArtwork)
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $categoryId = $this->option('category');
        if (! $categoryId) {
            $this->line('Please enter a category.');
            return Command::FAILURE;
        }

        $category = Category::findOrFail($categoryId);
        $this->confirm("Delete all artworks in category {$category->name}?");

        $numberDeleted = $this->deleteArtwork->execute($category);

        $this->line("Deleted {$numberDeleted} artwork(s).");

        return Command::SUCCESS;
    }
}
