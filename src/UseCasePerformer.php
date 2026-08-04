<?php

namespace OnrampLab\CleanArchitecture;

class UseCasePerformer
{
    public function perform(UseCase $useCase): mixed
    {
        return app()->call([$useCase, 'handle']);
    }
}
