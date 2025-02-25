<?php

namespace OnrampLab\CleanArchitecture\Infrastructure;

use OnrampLab\CleanArchitecture\Application\UseCase;

class UseCasePerformer
{
    public function perform(UseCase $useCase): mixed
    {
        return app()->call([$useCase, 'handle']);
    }
}
