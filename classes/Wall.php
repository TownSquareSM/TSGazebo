<?php
/**
 * Open Source Social Network
 *
 * @package   (softlab24.com).ossn
 * @author    OSSN Core Team <info@softlab24.com>
 * @copyright (c) SOFTLAB24 LIMITED
 * @license   http://www.opensource-socialnetwork.org/licence
 * @link      https://www.opensource-socialnetwork.org/
 */
class Wall extends OssnWall {
		/**
		 * Get user wall postings for wall mode set to All-Site-Posts 
		 *
		 * @param 
		 *
		 * @return array;
		 */
		public function getPublicPosts($params = array()) {
				$user = ossn_loggedin_user();
				if(isset($user->guid) && !empty($user->guid)) {
						$friends      = $user->getFriends();
						//operator not supported for strings #999
						$friend_guids = array();
						if($friends) {
								foreach($friends as $friend) {
										$friend_guids[] = $friend->guid;
								}
						}
						// add all users posts;
						// (if user has 0 friends, show at least his own postings if wall access type = friends only)
						$friend_guids[] = $user->guid;
						$friend_guids   = implode(',', $friend_guids);
						
						$default = array(
								'type' => 'user',
								'subtype' => 'wall',
								'order_by' => 'o.guid DESC',
								'joins' => array(
										'LEFT JOIN ossn_entities as le ON (le.owner_guid=o.guid AND le.type="object" AND le.subtype="item_type")',
										'LEFT JOIN ossn_entities_metadata as lemd ON (lemd.guid=le.guid)',
								),
								'entities_pairs' => array(
												array(
												  	'name' => 'access',
													'value' => true,
												  	'wheres' => "(1=1)"
												  ),
												array(
												  	'name' => 'poster_guid',
													'value' => true,
													'wheres' => "((emd0.value=2) OR (emd0.value=3 AND [this].value IN({$friend_guids})))"
												  ),
								),
								//initially app only support special wall posts profile:photos update or cover:photo update
								'wheres' => array('(le.guid IS NOT NULL AND lemd.value IN("profile:photo", "cover:photo", "") OR le.guid IS NULL)'),
						);
						
						$options = array_merge($default, $params);
						return $this->searchObject($options);
				}
				return false;
		}
		public function GetPostByOwner($owner, $type = 'user', $count = false) {
				self::initAttributes();
				if(empty($owner) || empty($type)) {
						return false;
				}
				$vars = array(
						'type' => $type,
						'subtype' => 'wall',
						'order_by' => 'o.guid DESC',
						'owner_guid' => $owner,
						'count' => $count,
						'joins' => array(
										'LEFT JOIN ossn_entities as le ON (le.owner_guid=o.guid AND le.type="object" AND le.subtype="item_type")',
										'LEFT JOIN ossn_entities_metadata as lemd ON (lemd.guid=le.guid)',
						),			
						//initially app only support special wall posts profile:photos update or cover:photo update
						'wheres' => array('(le.guid IS NOT NULL AND lemd.value IN("profile:photo", "cover:photo", "") OR le.guid IS NULL)'),						
				);
				return $this->searchObject($vars);
		}		
} //class