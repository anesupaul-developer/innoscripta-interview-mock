<?php

use App\Console\Commands\GuardianArticleCommand;
use App\Console\Commands\NewsApiArticleCommand;
use App\Console\Commands\NewYorkTimesArticleCommand;

Schedule::command(GuardianArticleCommand::class)
    ->withoutOverlapping()
    ->hourly();

Schedule::command(NewsApiArticleCommand::class)
    ->withoutOverlapping()
    ->hourly();

Schedule::command(NewYorkTimesArticleCommand::class)
    ->withoutOverlapping()
    ->hourly();
