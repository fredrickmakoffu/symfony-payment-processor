<?php

namespace App\Contracts\Validations;

use Symfony\Component\Validator\ConstraintViolationList;

interface ValidationServiceInterface
{
    /**
     * Validate the DTO and return constraint violations.
     *
     * @param array $data
     * @return ConstraintViolationList
     */
    public function handle(array $data): ConstraintViolationList;

    /**
		 * Build the DTO.
		 *
		 * @return self
		 */
		public function build(): self;

		/**
		 * Validate the DTO.
		 *
		 * @return ConstraintViolationList
		 */
		public function validate(): ConstraintViolationList;

    /**
     * Get the validated DTO.
     *
     * @return object
     */
    public function getValidatedDto(): object;

    /**
     * Get validation errors.
     *
     * @return ConstraintViolationListInterface
     */
    public function getErrors(): ConstraintViolationList;
}
