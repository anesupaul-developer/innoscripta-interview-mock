<?php

use App\Console\Commands\GuardianArticleCommand;
use App\Console\Commands\NewsApiArticleCommand;
use App\Console\Commands\NewYorkTimesArticleCommand;

Schedule::command(GuardianArticleCommand::class)
    ->withoutOverlapping()
    ->daily();

Schedule::command(NewsApiArticleCommand::class)
    ->withoutOverlapping()
    ->daily();

Schedule::command(NewYorkTimesArticleCommand::class)
    ->withoutOverlapping()
    ->daily();
