<?php

namespace App\GraphQL\Scalars;

use GraphQL\Error\Error;
use GraphQL\Language\AST\StringValueNode;
use GraphQL\Type\Definition\ScalarType;
use GraphQL\Utils\Utils;

/**
 * Read more about scalars here http://webonyx.github.io/graphql-php/type-system/scalar-types/
 */
class Date extends ScalarType
{
    /**
     * Serializes an internal value to include in a response.
     *
     * @param  mixed  $value
     * @return mixed
     */
    public function serialize($value)
    {
        return $value;
    }

    /**
     * Parses an externally provided value (query variable) to use as an input
     *
     * @param mixed $value
     * @return mixed
     * @throws Error
     */
    public function parseValue($value)
    {
        if (!$this->validate($value)) {
            throw new Error("Cannot represent following value as Date: " . Utils::printSafeJson($value));
        }
        return $value;
    }

    /**
     * Parses an externally provided literal value (hardcoded in GraphQL query) to use as an input.
     *
     * @param \GraphQL\Language\AST\Node $valueNode
     * @param array|null $variables
     * @return mixed|string
     * @throws Error
     */
    public function parseLiteral($valueNode, ?array $variables = null)
    {
        if (!$valueNode instanceof StringValueNode) {
            throw new Error('Query error: Can only parse strings got: ' . $valueNode->kind, [$valueNode]);
        }
        if (!$this->validate($valueNode->value)) {
            throw new Error("Not a valid Date: ", [$valueNode]);
        }
        return $valueNode->value;
    }

    /**
     * Validate (Format & Value as Date)
     *
     * @param $target
     * @return bool
     */
    private function validate($target): bool
    {
        if (!\is_string($target)) {
            return false;
        }
        return $target === \date('Y-m-d', \strtotime($target));
    }
}
