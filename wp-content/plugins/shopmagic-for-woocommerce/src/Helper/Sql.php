<?php
declare( strict_types=1 );

namespace WPDesk\ShopMagic\Helper;

class Sql {

	public function count(array $criteria = []): int
	{
		$sql = $this->getCountSQL($criteria);

		[$params, $types] = $this->expandParameters($criteria);

		return (int) $this->conn->executeQuery($sql, $params, $types)->fetchOne();
	}

	public function getCountSQL(array $criteria = []): string
	{
		$tableName  = $this->quoteStrategy->getTableName($this->class, $this->platform);
		$tableAlias = $this->getSQLTableAlias($this->class->name);

		$conditionSql = $this->getSelectConditionSQL($criteria);

		return 'SELECT COUNT(*) '
		       . 'FROM ' . $tableName . ' ' . $tableAlias
		       . (empty($conditionSql) ? '' : ' WHERE ' . $conditionSql);
	}

	/**
	 * Gets the conditional SQL fragment used in the WHERE clause when selecting
	 * entities in this persister.
	 *
	 * Subclasses are supposed to override this method if they intend to change
	 * or alter the criteria by which entities are selected.
	 *
	 * @psalm-param array<string, mixed> $criteria
	 * @psalm-param AssociationMapping|null $assoc
	 */
	protected function getSelectConditionSQL(array $criteria, array|null $assoc = null): string
	{
		$conditions = [];

		foreach ($criteria as $field => $value) {
			$conditions[] = $this->getSelectConditionStatementSQL($field, $value, $assoc);
		}

		return implode(' AND ', $conditions);
	}

	public function getSelectConditionStatementSQL(
		string $field,
		mixed $value,
		array|null $assoc = null,
		string|null $comparison = null
    ): string {
		$selectedColumns = [];
		$columns         = $this->getSelectConditionStatementColumnSQL($field, $assoc);

		if (count($columns) > 1 && $comparison === Comparison::IN) {
			/*
			 *  @todo try to support multi-column IN expressions.
			 *  Example: (col1, col2) IN (('val1A', 'val2A'), ('val1B', 'val2B'))
			 */
			throw CantUseInOperatorOnCompositeKeys::create();
		}

		foreach ($columns as $column) {
			$placeholder = '?';

			if (isset($this->class->fieldMappings[$field])) {
				$type        = Type::getType($this->class->fieldMappings[$field]['type']);
				$placeholder = $type->convertToDatabaseValueSQL($placeholder, $this->platform);
			}

			if ($comparison !== null) {
				// special case null value handling
				if (($comparison === Comparison::EQ || $comparison === Comparison::IS) && $value === null) {
					$selectedColumns[] = $column . ' IS NULL';

					continue;
				}

				if ($comparison === Comparison::NEQ && $value === null) {
					$selectedColumns[] = $column . ' IS NOT NULL';

					continue;
				}

				$selectedColumns[] = $column . ' ' . sprintf(self::$comparisonMap[$comparison], $placeholder);

				continue;
			}

			if (is_array($value)) {
				$in = sprintf('%s IN (%s)', $column, $placeholder);

				if (array_search(null, $value, true) !== false) {
					$selectedColumns[] = sprintf('(%s OR %s IS NULL)', $in, $column);

					continue;
				}

				$selectedColumns[] = $in;

				continue;
			}

			if ($value === null) {
				$selectedColumns[] = sprintf('%s IS NULL', $column);

				continue;
			}

			$selectedColumns[] = sprintf('%s = %s', $column, $placeholder);
		}

		return implode(' AND ', $selectedColumns);
	}

	/**
	 * Builds the left-hand-side of a where condition statement.
	 *
	 * @psalm-param AssociationMapping|null $assoc
	 *
	 * @return string[]
	 * @psalm-return list<string>
	 *
	 * @throws InvalidFindByCall
	 * @throws UnrecognizedField
	 */
	private function getSelectConditionStatementColumnSQL(
		string $field,
		array|null $assoc = null,
    ): array {
		if (isset($this->class->fieldMappings[$field])) {
			$className = $this->class->fieldMappings[$field]['inherited'] ?? $this->class->name;

			return [$this->getSQLTableAlias($className) . '.' . $this->quoteStrategy->getColumnName($field, $this->class, $this->platform)];
		}

		if (isset($this->class->associationMappings[$field])) {
			$association = $this->class->associationMappings[$field];
			// Many-To-Many requires join table check for joinColumn
			$columns = [];
			$class   = $this->class;

			if ($association['type'] === ClassMetadata::MANY_TO_MANY) {
				if (! $association['isOwningSide']) {
					$association = $assoc;
				}

				$joinTableName = $this->quoteStrategy->getJoinTableName($association, $class, $this->platform);
				$joinColumns   = $assoc['isOwningSide']
					? $association['joinTable']['joinColumns']
					: $association['joinTable']['inverseJoinColumns'];

				foreach ($joinColumns as $joinColumn) {
					$columns[] = $joinTableName . '.' . $this->quoteStrategy->getJoinColumnName($joinColumn, $class, $this->platform);
				}
			} else {
				if (! $association['isOwningSide']) {
					throw InvalidFindByCall::fromInverseSideUsage(
						$this->class->name,
						$field,
                    );
				}

				$className = $association['inherited'] ?? $this->class->name;

				foreach ($association['joinColumns'] as $joinColumn) {
					$columns[] = $this->getSQLTableAlias($className) . '.' . $this->quoteStrategy->getJoinColumnName($joinColumn, $this->class, $this->platform);
				}
			}

			return $columns;
		}

		if ($assoc !== null && ! str_contains($field, ' ') && ! str_contains($field, '(')) {
			// very careless developers could potentially open up this normally hidden api for userland attacks,
			// therefore checking for spaces and function calls which are not allowed.

			// found a join column condition, not really a "field"
			return [$field];
		}

		throw UnrecognizedField::byFullyQualifiedName($this->class->name, $field);
	}


}
