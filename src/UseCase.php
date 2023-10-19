<?php

namespace OnrampLab\CleanArchitecture;

use Illuminate\Http\Response;
use OnrampLab\CleanArchitecture\Exceptions\GeneralException;
use OnrampLab\CleanArchitecture\Exceptions\InternalServerException;
use OnrampLab\CleanArchitecture\Exceptions\UseCaseException;
use OnrampLab\CleanArchitecture\Facades\UseCaseFacade;
use ReflectionClass;
use Spatie\LaravelData\Data;
use Throwable;

class UseCase extends Data
{
    public static function perform(mixed $args): mixed
    {
        $useCase = null;
        $useCaseName = static::getName();

        try {
            try {
                $useCase = static::validateAndCreate($args);

                /** @phpstan-ignore-next-line  */
                return UseCaseFacade::perform($useCase);
            } catch (GeneralException $e) {
                throw $e;
            } catch (Throwable $e) {
                throw new InternalServerException(
                    $e->getMessage(),
                    is_null($useCase) ? [] : $useCase->toArray(),
                    Response::HTTP_INTERNAL_SERVER_ERROR,
                    $e
                );
            }
        } catch (UseCaseException $e) {
            throw $e;
        } catch (GeneralException $e) {
            throw new UseCaseException("Unable To {$useCaseName}", $e->context(), $e);
        }
    }

    public static function getName(): string
    {
        $reflect = new ReflectionClass(static::class);
        $className = str_replace('UseCase', '', $reflect->getShortName());

        // Dynamically tranform class name to space-sparated words.
        // E.x. "SendWelcomeMessage" to "Send Welcome Message"
        $useCaseName = preg_replace('/(?|([A-Z])([A-Z][a-z])|([a-z])([A-Z]))/', '$1 $2', $className);

        return $useCaseName ?? 'Do Unknown Use Case';
    }
}
