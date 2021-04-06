<?php
    function s360_log( $text ){

        $path = trailingslashit( get_stylesheet_directory() . "/logs/");

        if( !is_dir( $path ) )
            mkdir( $path, 0777, true );

        $file = $path . time() . '.log';

        $handle = fopen( $file, "a+" );
        $text   = strip_tags( $text );

        fwrite( $handle, $text );
        fclose( $handle );
    }

    function s360_unique_ids( $coma_ids ){

        $ret = [];

        if( !empty($coma_ids) ){

            $coma_ids   = trim( ",", $coma_ids );
            $ids        = explode( ",", $coma_ids );

            foreach( $ids as $i ){
                if( abssint($i) && !in_array( $i, $ret ) )
                    $ret[] = $i;
            }
        }

        return $ret;
    }
?>
