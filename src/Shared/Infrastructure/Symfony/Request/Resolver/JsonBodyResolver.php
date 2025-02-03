<?php

declare(strict_types=1);

namespace App\RateTv\Shared\Infrastructure\Symfony\Request\Resolver;

use App\RateTv\Shared\Infrastructure\Symfony\Request\Validator\ValidationError;
use App\RateTv\Shared\Infrastructure\Utils\Request\RequestInterface;
use Generator;
use InvalidArgumentException;
use RuntimeException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Controller\ValueResolverInterface;
use Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata;
use Symfony\Component\Serializer\Normalizer\AbstractObjectNormalizer;
use Symfony\Component\Serializer\SerializerInterface;
use UnexpectedValueException;

final readonly class JsonBodyResolver implements ValueResolverInterface
{
    private const string FORMAT = 'json';

    public function __construct(private SerializerInterface $serializer)
    {
    }

    /**
     * @throws ValidationError
     *
     * @return Generator
     */
    public function resolve(Request $request, ArgumentMetadata $argument): iterable
    {
        if (! $this->supports($argument)) {
            return;
        }

        try {
            yield $this->serializer->deserialize(
                empty($request->getContent()) ? '{}' : $request->getContent(),
                $argument->getType() ?? '',
                self::FORMAT,
                [
                    AbstractObjectNormalizer::DISABLE_TYPE_ENFORCEMENT => true,
                ]
            );
        } catch (UnexpectedValueException|InvalidArgumentException|RuntimeException) {
            throw new ValidationError([
                ValidationError::GENERAL => 'VALIDATION.INVALID_PAYLOAD',
            ]);
        }
    }

    private function supports(ArgumentMetadata $argument): bool
    {
        $type = (string) $argument->getType();

        if (! class_exists($type)) {
            return false;
        }

        return \in_array(RequestInterface::class, class_implements($type), true);
    }
}
