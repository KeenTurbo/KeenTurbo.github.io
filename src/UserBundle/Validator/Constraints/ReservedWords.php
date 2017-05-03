<?php

namespace UserBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * @author Wenming Tang <wenming@cshome.com>
 *
 * @Annotation
 */
class ReservedWords extends Constraint
{
    public $message = 'The string "{{ value }}" contains an reserved words.';
}