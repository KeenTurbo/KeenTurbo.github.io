<?php

namespace UserBundle\Validator\Constraints;

use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

/**
 * @author Wenming Tang <wenming@cshome.com>
 */
class ReservedWordsValidator extends ConstraintValidator
{
    /**
     * @var Container
     */
    private $container;

    /**
     * ReservedWordsValidator constructor.
     *
     * @param Container $container
     */
    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    /**
     * {@inheritdoc}
     */
    public function validate($value, Constraint $constraint)
    {
        if ($this->isReservedWord($value)) {
            $this->context->buildViolation($constraint->message)
                ->setParameter('{{ value }}', $value)
                ->addViolation();
        }
    }

    /**
     * @param string $value
     *
     * @return bool
     */
    private function isReservedWord($value)
    {
        if (!$this->container->hasParameter('validator_reserved_words')) {
            throw new \LogicException('The parameter "validator_reserved_words" is not configured in your application.');
        }

        $reservedWords = $this->container->getParameter('validator_reserved_words');

        if (!is_array($reservedWords)) {
            throw new \LogicException('The parameter "validator_reserved_words" is not an array.');
        }

        foreach ($reservedWords as $reservedWord) {
            if (false !== stripos($value, $reservedWord)) {
                return true;
            }
        }

        return false;
    }
}