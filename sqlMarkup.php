<?php
/*
SQLMarkup by Julius Schlosburg May 2012

This file is part of SQLMarkup.

    SQLMarkup is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.

    SQLMarkup is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with SQLMarkup.  If not, see <http://www.gnu.org/licenses/>.
*/

	//This class applies some HTML tags with CSS classes for SQL syntax highlighting on the web. It needs a string containing the SQL text, and,
        //if you want, a flag for "beautifying" the text, which simply removes extra whitespace. In future revisions all of the beautifying will be
	//controlled with this flag, but for now a lot of it is not possible to turn off.
	class SQLMarkup{
		//Internals here are simple - a set of regular expressions for surrounding pieces of a SQL statement with 
		//HTML tags with classes for each type of SQL reserved word or language construct

		//First set of expressions deal with inserting tags for highlighting. Some beautification happening as well as highlighting
		
		//$sqlRWord operates on SQL reserved words, tagging them with 'sqlRWord' class. All words matched here will automatically 
		//have a <br /> tag inserted BEFORE them
		private $sqlRWordPattern = '/(SELECT\s|\sAND\s|\sOR\s|\sFROM\s|\sWHERE\s|\sGROUP\sBY\s|\sORDER\sBY\s|\bINSERT\b)/i';
		private $sqlRWordReplacement = '<br/><span class="sqlRWord">$1</span>';

		//$sqlRWordNR operates on SQL reserved words, tagging them with 'sqlRWord' class. NR stands for "No Return," so no <br /> tags are 
		//added with these
		private $sqlRWordPatternNR = '/(ON\s|\sRIGHT JOIN\s|\sLEFT JOIN\s|\sJOIN\s|\sINNER JOIN\s|\sRIGHT INNER JOIN\s|\sLEFT INNER JOIN\s|\bAS\b|\bBETWEEN\b|\bDESC\b|\bASC\b|\\bLIMIT\b|\bNOT\b|\bIN\b|\bIS\b|\bNULL\b|\bINTO\b)/i';
		private $sqlRWordReplacementNR = '<span class="sqlRWord">$1</span>';

		//$sqlFunction operates on functions and tags them with the 'sqlFunction' class
		private $sqlFunctionPattern = '/\b(\w+)\(/i';
		private $sqlFunctionReplacement = '<span class="sqlFunction">$1</span>(';

		//$sqlData tags numbers and strings with 'sqlData'
		private $sqlDataPattern = '/(\'.*?\'|\bN\b|\b\d+?\.?\d*?\b)/';
		private $sqlDataReplacement = '<span class="sqlData">$1</span>';

		//$sqlWrap simply tags the entire statement with tag 'sqlWrap'
		private $sqlWrapPattern = '/^(.*)$/';
		private $sqlWrapReplacement = '<span class="sqlWrap">$1</span>';

		//Postprocesses entire string to remove spare <br /> tag at top. This is activated if $blanksClean is on
		private $sqlRemoveBlanksPattern = '/(sqlWrap.*?)<br.*?(<span)/';
		private $sqlRemoveBlanksReplacement = '$1$2';

		private $statement = '';
		//Init blanksClean as true by default
		private $blanksCleanFlag = true;

		//Sets the SQL statement we want to work with
		public function setStatement($statement){
			$this->statement = $statement;
		}

		public function getStatement(){
			return $statement;
		}

		//set whether or not we want to clean blank lines. On by default
		public function setBlanksClean($flag){
			if ($flag){
				$this->blanksCleanFlag = TRUE;
			}
			else{
				$this->blanksCleanFlag = FALSE;
			}
		}

		private $statementTemp = '';
		public function getMarkedStatement(){
			$this->statementTemp = $this->statement;
			$this->statementTemp = preg_replace($this->sqlRWordPattern,$this->sqlRWordReplacement,$this->statementTemp);
			$this->statementTemp = preg_replace($this->sqlRWordPatternNR,$this->sqlRWordReplacementNR,$this->statementTemp);
			$this->statementTemp = preg_replace($this->sqlFunctionPattern,$this->sqlFunctionReplacement,$this->statementTemp);
			$this->statementTemp = preg_replace($this->sqlDataPattern,$this->sqlDataReplacement,$this->statementTemp);
			$this->statementTemp = preg_replace($this->sqlWrapPattern,$this->sqlWrapReplacement,$this->statementTemp);
			if ($this->blanksCleanFlag){
				$this->statementTemp = preg_replace($this->sqlRemoveBlanksPattern,$this->sqlRemoveBlanksReplacement,$this->statementTemp);
			}
			return $this->statementTemp;
		}
	}
?>
