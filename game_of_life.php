<?php

/*
 * This class contains core methods to compute a future stage in a game of 
 * life simulation.
 *
 * @author zmughal89@gmail.com
 */

//define( 'DEBUG', TRUE );

class game_of_life {

    //================================================================================
    // Properties
    //================================================================================

    private $state = NULL;
    private $width = NULL;
    private $height = NULL;
    private $infinite_board = NULL;

    //================================================================================
    // Constructors
    //================================================================================

    function __construct( $state, $infinite_board = True ) {
        $this->state = $state;
        $this->width = $state->get_width();
        $this->height = $state->get_height();
        $this->infinite_board = $infinite_board;
    }

    function step( $count = 1 ) {

        for ( $generation = 0; $generation < $count; $generation++ ) {

            // create a 2d array with all zeros
            $new_board = array_fill(0, $this->height, array_fill(0, $this->width, 0));
            
            if ( defined('DEBUG') ) {
                print $this->width;
                print $this->height;
                var_dump($new_board);
                var_dump($this->state->get_board());
            }

            foreach ( $this->state->get_board() as $y => $row ) {
                foreach ($row as $x => $cell) {
                    $neighbours = $this->neighbours($x, $y);
                    $board = $this->state->get_board();
                    $previous_state = $board[$y][$x];
                    $should_live = TRUE ? $neighbours == 3 || ($neighbours == 2 && $previous_state == TRUE) : FALSE;
                    $new_board[$y][$x] = $should_live;
                }
            }

            if ( defined('DEBUG') ) {
                var_dump($new_board);
            }

            $this->state->set_board($new_board);
        }
    }
    
    function neighbours($x, $y) {

        $count = 0;

        foreach ( array(-1, 0, 1) as $hor ) {
            foreach ( array(-1, 0, 1) as $ver ) {
                if (($hor == 0 && $ver == 0) == FALSE && 
                    ($this->infinite_board == TRUE || 
                        ($x + $hor >= 0 && $x + $hor < $this->width && $y + $ver >= 0 && $y + $ver < $this->height))) {
                    $board = $this->state->get_board();
                    $count += $board[($y + $ver) % $this->height][($x + $hor) % $this->width];
                }
            }
        }
        return $count;
    }

    function display() {
        return $this->state->display();
    }
}

/*
 * This class has methods for parsing input to initialize the beginning pattern and
 * displaying pattern after n generations.
 *
 * @author zmughal89@gmail.com
 */

Class state {

    //================================================================================
    // Properties
    //================================================================================

    private $board = NULL;
    private $width = NULL;
    private $height = NULL;

    //================================================================================
    // Constructors
    //================================================================================

    function __construct( $positions, $width, $height ) {

        $active_cells = array();


        if ( defined('DEBUG') ) {
            print $positions;
        }
  
        foreach (preg_split("/\r\n|\n|\r/", $positions) as $y => $row) {
            
            if ( defined('DEBUG') )
                print $row;
            
            foreach (str_split(trim($row)) as $x => $cell)  {
                if ($cell == 'o') {
                    array_push($active_cells, array($x,$y));
                }
        
                if ( defined('DEBUG') ) 
                    print $cell . " ";
            }
            if ( defined('DEBUG') ) 
                print "/n";
        }

        $board = array_fill(0, $height, array_fill(0, $width, 0));

        foreach ($active_cells as $cell) {
            $board[$cell[1]][$cell[0]] = TRUE;
        }

        $this->board = $board;
        
        if ( defined('DEBUG') ) 
            var_dump($this->board);
        
        $this->width = $width;
        $this->height = $height;
    }

    //================================================================================
    // Accessors
    //================================================================================

    function get_width() {
        return $this->width;
    }

    function get_height() {
        return $this->height;
    }

    function get_board() {
        return $this->board;
    }

    //================================================================================
    // Mutator
    //================================================================================

    function set_board( $board ) {
        return $this->board = $board;
    }

    function display() {

        $output = '';

        if ( defined('DEBUG') ) 
            var_dump($this->board);
        
        foreach ( $this->board as $y => $row ) {
            $output .= '<tr>';
            foreach ( $row as $x => $cell ) {
                if ($cell ==  True) {
                    $output .= ' <td class="on"></td>';
                } else {
                    $output .= ' <td class="off"></td>';
                }
            }
            $output .= '</tr>';
        }
        return $output;
    }
}



