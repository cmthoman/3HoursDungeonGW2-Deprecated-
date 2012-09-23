<?php 

class SearchBehavior extends ModelBehavior { 

    function search(&$model, $q, $options = array()) { 

        App::uses('Sanitize', 'Utility'); 
        $q = Sanitize::escape($q); 

        $myopts = array('conditions' => array( 
                'MATCH(' . implode(",", $model->fulltext) . ') AGAINST("' . $q . '" IN BOOLEAN MODE)' 
                )); 

        $opts = array_merge_recursive($myopts, $options); 

        return $model->find('all', $opts); 
    }
	
	function search3(&$model, $q, $options = array()) { 

        App::uses('Sanitize', 'Utility'); 
        $q = Sanitize::escape($q); 

        $myopts = array('conditions' => array( 
                'MATCH(' . implode(",", $model->fulltext) . ') AGAINST("' . $q . '" IN BOOLEAN MODE) LIMIT 0, 3' 
                )); 

        $opts = array_merge_recursive($myopts, $options); 

        return $model->find('all', $opts); 
    }
	
	function search5(&$model, $q, $options = array()) { 

        App::uses('Sanitize', 'Utility'); 
        $q = Sanitize::escape($q); 

        $myopts = array('conditions' => array( 
                'MATCH(' . implode(",", $model->fulltext) . ') AGAINST("' . $q . '" IN BOOLEAN MODE) LIMIT 0, 3' 
                )); 

        $opts = array_merge_recursive($myopts, $options); 

        return $model->find('all', $opts); 
    }
	
	function searchCount(&$model, $q, $options = array()) { 

        App::uses('Sanitize', 'Utility'); 
        $q = Sanitize::escape($q); 

        $myopts = array('conditions' => array( 
                'MATCH(' . implode(",", $model->fulltext) . ') AGAINST("' . $q . '" IN BOOLEAN MODE)' 
                )); 

        $opts = array_merge_recursive($myopts, $options); 

        return $model->find('count', $opts); 
    } 

} 

?> 