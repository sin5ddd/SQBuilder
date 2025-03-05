<?php
	
	namespace sin5ddd\SQBuilder\Builder;
	
	use sin5ddd\SQBuilder\Keys\AlterCmd;
	use sin5ddd\SQBuilder\Builder\Interface\IModifier;
	use sin5ddd\SQBuilder\Builder\Interface\MIGRATION_TYPE;
	
	
	class Alter extends IModifier {
		
		/**
		 * @var array<AlterCmd>
		 */
		protected array $command;
		
		public function __construct(string $table_name) {
			$this->method = "ALTER";
			$this->table_name = $table_name;
		}
		
		public function addCommand(AlterCmd $command) : IModifier {
			$this->command[] = $command;
			return $this;
		}
		
		public function build(MIGRATION_TYPE $type = MIGRATION_TYPE::BOTH) :string {
			$res="$this->method TABLE $this->table_name ";
			$str_arr=[];
			foreach ($this->command as $cmd) {
				$str_arr[]=$cmd->bake();
			}
			$res .= implode(",", $str_arr).";";
			return $res;
		}
		public function buildToFile(?string $path = null): void{
			$this->toFile($this->build(),$path);
		}
	}