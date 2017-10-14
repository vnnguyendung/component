<?

// Cck_User to 
$createUserApp = new Cck_User();

$column1_user = array(
    'name'      => 'careless4',
    'username'  => 'careless4',
    'email'     => 'careless4@gmail.com',
);
$column2_user =   array(
    // Seblod table ie #__cck_store_form_cauliflower
    'user_hnv_tugioithieu'=> 'careless3',
);

$newuser = $createUserApp->create('user',$column1_user,$column2_user);
dump($newuser,'newuser');

    $type   =    "joomla_article";
    $pk     =       $newuser->getPk();
    $object_user    = $newuser->getDataObject();
    $tb_code_id     =  $newuser->getId();
    g_doBridge( $type, $tb_code_id, $pk, $object_user );


    function g_doBridge( $type, $tb_code_id, $pk, $object_user )
{
         
        $core	=	JCckTable::getInstance( '#__cck_core', 'id' );
      
        $core->load( $tb_code_id );
        
        JLoader::register( 'JTableContent', JPATH_PLATFORM.'/joomla/database/table/content.php' );
        $bridge		=	JTable::getInstance( 'Content' );
        $dispatcher	=	JEventDispatcher::getInstance();
        
        if ( $core->pkb > 0 ) {
            $bridge->load( $core->pkb );
            $bridge->introtext	=	'';
            $isNew				=	false;
        } else {
            $bridge->access		=	'1';
            $bridge->state		=	'1';
           // g_initTable( $bridge, $params, false, 'bridge_' );
            $isNew				=	true;
        }
        $bridge->created_by		=	$pk; 
              
        $bridge->title		=	trim( $object_user->username );  /// = user.username
        
        // get cat_id default for save artilce
        $bridge->catid	=	8;
        
        
      
        $bridge->introtext	=	'::cck::'.$tb_code_id.'::/cck::'.$bridge->introtext; 
        $bridge->version++;
        
        if ( $bridge->state == 1 && intval( $bridge->publish_up ) == 0 ) {
            $bridge->publish_up	=	substr( JFactory::getDate()->toSql(), 0, -3 );
        }
        if ( !$core->pkb ) {
          
                $max				=	JCckDatabase::loadResult( 'SELECT MAX(ordering) FROM #__content WHERE catid = '.(int)$bridge->catid );
                $bridge->ordering	=	(int)$max + 1;
    
        }
        $bridge->check();
        
        if ( empty( $bridge->language ) ) {
            $bridge->language	=	'*';
        }
        
        JPluginHelper::importPlugin( 'content' );
        $dispatcher->trigger( 'onContentBeforeSave', array( 'com_content.article', &$bridge, $isNew ) );
        if ( !$bridge->store() ) {
            if ( $isNew ) {
                $test	=	JTable::getInstance( 'Content' );
                for ( $i = 2; $i < 69; $i++ ) {
                    $alias	=	$bridge->alias.'-'.$i;
                    if ( !$test->load( array( 'alias'=>$alias, 'catid'=>$bridge->catid ) ) ) {
                        $bridge->alias	=	$alias;
                        $bridge->store();
                        break;
                    }
                }
            }
        }
        
        
        
        $core->pkb	=	( $bridge->id > 0 ) ? $bridge->id : 0;
        $core->cck	=	'user';
        if ( ! $core->pk ) {
            $core->author_id	=	$pk;
            $core->date_time	=	JFactory::getDate()->toSql();
        }
        $core->pk	=	$pk;
        $core->storage_location	=	'joomla_user';
        $core->author_id		=	$pk;
        $core->storeIt();
        
        dump($bridge,'bridge');
        dump($core,'bridge');
        
        $group_id = '2';
        JUserHelper::addUserToGroup( $pk, $group_id );
        
        $dispatcher->trigger( 'onContentAfterSave', array( 'com_content.article', &$bridge, $isNew ) );
    
}


function g_initTable( &$table, $params = array(), $force = false, $prefix = 'base_' )
{
    if ( count( $params ) ) {
        if ( $force === true ) {
            foreach ( $params as $k => $v ) {
                if ( ( $pos = strpos( $k, $prefix.'default-' ) ) !== false ) {
                    $length		=	strlen( $prefix ) + 8;
                    $k			=	substr( $k, $length );
                    $table->$k	=	$v;
                }
            }
        } else {
            foreach ( $params as $k => $v ) {
                if ( ( $pos = strpos( $k, $prefix.'default-' ) ) !== false ) {
                    $length	=	strlen( $prefix ) + 8;
                    $k		=	substr( $k, $length );
                    if ( $table->$k == '' || !isset( $table->$k ) ) {
                        $table->$k	=	$v;
                    }
                }
            }
        }
    }
}