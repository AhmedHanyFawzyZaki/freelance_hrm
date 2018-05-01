<?php

class ApiController extends Controller {

    public $PROJECT_URL = "http://egysn.com";
    public $PROJECT_NAME = "First Pout API";
    public $MESSAGE_SUCCESS = "success";
    public $WRONG_EMAIL = "wrong_email";
    public $WRONG_PASSWORD = "wrong_password";
    public $MESSAGE_ERROR = "error";
    public $MESSAGE_FAIL_EX = "fail_ex";
    public $MESSAGE_ACCESS_DENIED = "access_denied";
    public $MESSAGE_EMAIL_NOT_FOUND = "invalid_mail";
    public $USER_NOTFOUND = "not_found";
    public $NOTFOUND = "No Results Found";
    public $TOKEN_FAILED = "No_Access_Token";
    public $MESSAGE_REGISTERED_BEFORE = "registered_before";
    public $MESSAGE_REGISTERED_EMPTY = "EMPTY EMAIL OR PASSWORD";
    public $TOKEN_NOT_FOUND = "token_not_found";
    public $BOOK_ERROR = "Booking Not Found";
    public $layout = ' ';
    public $NOTFOUNDPAGE = "page not fount";
    public $CONTACTERROR = "please fill all fields";

    public function actionError() {
        $this->responseWithMessage($this->MESSAGE_ERROR);
    }

    public function actionIndex() {
        $this->actionError();
    }

    public function actionTest($action) {
        $this->render('test');
    }

    public function actionintitalrequestttttttttttttttttttttttttttttt() {
        try {
            $request = $this->parseRequest();
            if ($request != false) {
                
            }
        } catch (Exception $ex) {
            $this->responseWithMessage($this->MESSAGE_FAIL_EX);
        }
    }

    public function parseRequest() {
        try {
            $json = file_get_contents('php://input');
            $_POST['data'] = $json;
            if (isset($_POST) && count($_POST) > 0) {
                $request = json_decode($_POST['data'], true);
                if ($request) {
                    return $request;
                } else {
                    $this->responseWithMessage($this->MESSAGE_ERROR);
                }
            } else {
                $this->responseWithMessage($this->MESSAGE_ERROR);
            }
        } catch (Exception $ex) {
            $this->responseWithMessage($this->MESSAGE_ERROR);
        }
        die();
    }

    public function stringVal($val) {
        return $val == null ? "" : $val;
    }

    public function integerVal($val) {
        return $val == null ? 0 : $val;
    }

    public function checkUserDataFound($key, $value, $id = '') {
        $user_model = User::model()->findByAttributes(array($key => $value));
        if ($user_model) {
            if ($id != '') {
                if ($user_model->id != $id) {
                    $this->responseWithMessage($key . '_found');
                    die();
                }
            } else {
                $this->responseWithMessage($key . '_found');
                die();
            }
        }
    }

    public function fetchUserObject($user) {
        if (count($user) == 0) {
            return new stdClass();
        } else {
            //$user->image = $user->image ? (strpos($user->image, "http://") !== false ? $user->image : $this->PROJECT_URL . $user->image) : '';
			if($user->image){
				if(strpos($user->image, "http://") !== false || strpos($user->image, "https://") !== false){
					$user->image=$user->image;
				}else{
					$user->image=$this->PROJECT_URL . $user->image;
				}
			}else{
				$user->image="";
			}
            $arr = array();
            $arr["id"] = $this->integerVal($user->id);
            $arr["email"] = $this->stringVal($user->email);
            $arr["firstName"] = $this->stringVal($user->fname);
            $arr["lastName"] = $this->stringVal($user->lname);
            $arr["gender"] = $this->integerVal($user->gender);
            $arr["birthday"] = $this->stringVal($user->date_of_birth);
            $arr["image"] = $this->stringVal($user->image);
            $arr["phone"] = $this->stringVal($user->phone);
            $arr["username"] = $this->stringVal($user->username);
            /*             * ***new (added when i added doctor and hospital api)**** */
            $arr["city"] = $this->stringVal($user->city);
            $arr["street"] = $this->stringVal($user->street);
            $arr["country"] = $this->stringVal($user->count->country_name);
            $arr["description"] = $this->stringVal($user->desc);
            return $arr;
        }
    }

    public function fetchGroupObject($model) {
        if (count($model) == 0) {
            return new stdClass();
        } else {
            $arr['name'] = $model->title;
            $arr['userId'] = $model->user_id;
            $arr['username'] = $model->user->username;
            $arr['userImage'] = $model->user->image;
            $arr['banner'] = $model->banner;
            $arr['privacy'] = $model->privacy;
            $arr['creationDate'] = $model->date_created;
            $arr['description'] = $model->other;
            $admins = GroupUser::model()->findAll(array('condition' => 'role=1 and group_id=' . $model->id));
            if ($admins) {
                foreach ($admins as $ad) {
                    $ar['adminId'] = $ad->user_id;
                    $ar['adminName'] = $ad->user->username;
                    $ar['adminImage'] = $ad->user->image;
                    $arr["admins"][] = $ar;
                }
            }
            $users = GroupUser::model()->findAll(array('condition' => 'role=1 and group_id=' . $model->id));
            if ($users) {
                foreach ($users as $ad) {
                    $ar['userId'] = $ad->user_id;
                    $ar['userName'] = $ad->user->username;
                    $ar['userImage'] = $ad->user->image;
                    $arr["users"][] = $ar;
                }
            }
            $invitees = GroupInvitee::model()->findAll(array('condition' => 'status=0 and group_id=' . $model->id));
            if ($invitees) {
                foreach ($invitees as $ad) {
                    $ar['inviteeId'] = $ad->user_id;
                    $ar['inviteeName'] = $ad->user->username;
                    $ar['inviteeImage'] = $ad->user->image;
                    $arr["invitees"][] = $ar;
                }
            }
            $requests = GroupInvitee::model()->findAll(array('condition' => 'status=1 and group_id=' . $model->id));
            if ($requests) {
                foreach ($requests as $ad) {
                    $ar['requestId'] = $ad->user_id;
                    $ar['requestName'] = $ad->user->username;
                    $ar['requestImage'] = $ad->user->image;
                    $arr["requests"][] = $ar;
                }
            }
            return $arr;
        }
    }

    public function fetchBabyObject($baby) {
        if (count($baby) == 0) {
            return new stdClass();
        } else {
            $baby->image = $baby->image ? (strpos($baby->image, "http://") !== false ? $baby->image : $this->PROJECT_URL . $baby->image) : '';
            $baby->banner = $baby->banner ? (strpos($baby->banner, "http://") !== false ? $baby->banner : $this->PROJECT_URL . $baby->banner) : '';
            $arr = array();
            $birth_day = explode(' ', $baby->date_of_birth);
            $birth_time = explode(':', $birth_day[1]);
            $pergacy_time = explode('-', $baby->date_of_pergacy);
            $name = explode(' ', $baby->username);
            $arr["id"] = $this->integerVal($baby->id);
            $arr["babyName"] = $this->stringVal($baby->username);
            //$arr["firstName"] = $this->stringVal($name[0]);
            //$arr["lastName"] = $this->stringVal($name[1]);
            $arr["gender"] = $this->integerVal($baby->gender);
            $arr["birthday"] = $this->stringVal($birth_day[0]);
            $arr["birthTime"] = $this->stringVal($birth_time[0] . ':' . $birth_time[1]);
            $arr["birthPlace"] = $this->stringVal($baby->birth_place);
            $arr["sunSign"] = $this->integerVal($baby->sun_sign);
            $arr["pregnacyTime"] = $this->stringVal($baby->date_of_pergacy);
            //$arr["pregnacyTime"]=$this->stringVal($pergacy_time[0].' Months '.$pergacy_time[1].' days');
            $arr["image"] = $this->stringVal($baby->image);
            $arr["banner"] = $this->stringVal($baby->banner);
            $arr["bloodType"] = $this->stringVal($baby->blood_type);
            $arr["height"] = $this->stringVal($baby->height);
            $arr["weight"] = $this->stringVal($baby->weight);
			$doctors=BabyDoctorHospital::model()->findAllByAttributes(array('baby_id'=>$baby->id, 'is_hospital'=>0));
			$hospitals=BabyDoctorHospital::model()->findAllByAttributes(array('baby_id'=>$baby->id, 'is_hospital'=>1));
			$doc_arr=array();
			$hos_arr=array();
			if($doctors){
				foreach($doctors as $doc){
					$doc_arr[]=array('name'=>$doc->doctor->username, 'phone'=>$doc->doctor->phone);
				}
			}
			if($hospitals){
				foreach($hospitals as $hos){
					$hos_arr[]=array('username'=>$hos->doctor->username, 'phone'=>$hos->doctor->phone, 'city'=>$hos->doctor->city);
				}
			}
			$arr['doctors']=$doc_arr;
			$arr['hospitals']=$hos_arr;
            //$arr["bodyMass"] = $this->stringVal($baby->body_mass);
            return $arr;
        }
    }

    public function fetchAlbumObject($model) {
        if (count($model) == 0) {
            return new stdClass();
        } else {
            $arr = array();
            $arr["id"] = $this->integerVal($model->id);
            $arr["title"] = $this->stringVal($model->title);
            $arr["babyId"] = $this->integerVal($model->baby_id);
            $arr["userId"] = $this->integerVal($model->user_id);
            //$arr["groupId"] = $this->integerVal($model->group_id);
            $arr["albumDate"] = $this->stringVal($model->date_of_album);
            $arr["description"] = $this->stringVal($model->desc);
            $arr["private"] = $this->integerVal($model->private);

            $arr["images"] = array();
            $filePath = Yii::app()->getBaseUrl(true) . '/media/albums/';
            $medias = AlbumImage::model()->findAll(array('condition' => 'album_id=' . $model->id));
            if ($medias) {
                foreach ($medias as $md) {
                    $arr["images"][] = $filePath . $md->image;
                }
            }
            /* if ($model->album_id) {
              $images = AlbumImage::model()->findAll(array('condition' => 'album_id=' . $model->album_id));
              if ($images) {
              foreach ($images as $img) {
              $arr["images"][] = $filePath . $img->image;
              }
              }
              } */
            return $arr;
        }
    }

    public function fetchPostObject($model) {
        if (count($model) == 0) {
            return new stdClass();
        } else {
            $arr = array();
            $arr["id"] = $this->integerVal($model->id);
            $arr["content"] = $this->stringVal($model->content);
            $arr["babyId"] = $this->integerVal($model->baby_id);
            $arr["userId"] = $this->integerVal($model->user_id);
            $arr["groupId"] = $this->integerVal($model->group_id);
            $arr["dateCreated"] = $this->stringVal($model->date_created);

            $fav = Favourite::model()->findByAttributes(array('user_id' => $model->user_id, 'item_type' => 1, 'item_id' => $model->id));
            if ($fav)
                $arr["isFav"] = 1;
            else
                $arr["isFav"] = 0;

            $arr["comments"] = Comment::model()->count(array('condition' => 'item_id="' . $model->id . '" and item_type=1'));
            $arr["likes"] = Like::model()->count(array('condition' => 'item_id="' . $model->id . '" and item_type=1'));

            $arr["image"] = $model->image ? $this->stringVal(Yii::app()->getBaseUrl(true) . '/media/posts/' . $model->image) : '';
            $arr["video"] = $model->video ? $this->stringVal(Yii::app()->getBaseUrl(true) . '/media/posts/' . $model->video) : '';
            $arr["images"] = array();
            $filePath = Yii::app()->getBaseUrl(true) . '/media/albums/';
            $medias = PostMedia::model()->findAll(array('condition' => 'post_id=' . $model->id));
            if ($medias) {
                foreach ($medias as $md) {
                    $arr["images"][] = $filePath . $md->media;
                }
            }
            /* if ($model->album_id) {
              $images = AlbumImage::model()->findAll(array('condition' => 'album_id=' . $model->album_id));
              if ($images) {
              foreach ($images as $img) {
              $arr["images"][] = $filePath . $img->image;
              }
              }
              } */
            return $arr;
        }
    }

    public function fetchAppointmentObject($model) {
        if (count($model) == 0) {
            return new stdClass();
        } else {
            $arr = array();
            $arr["id"] = $this->integerVal($model->id);
            $arr["title"] = $this->stringVal($model->title);
            $arr["babyId"] = $this->integerVal($model->baby_id);
            $arr["babyName"] = $this->stringVal($model->baby->username);
            $arr["userId"] = $this->integerVal($model->user_id);
            $arr["userName"] = $this->stringVal($model->user->username);
            $arr["doctorId"] = $this->integerVal($model->doctor_id);
            $arr["doctorName"] = $this->stringVal($model->doctor->username);
            $arr["hospitalId"] = $this->integerVal($model->hospital_id);
            $arr["hospitalName"] = $this->stringVal($model->hospital->username);
            $arr["date"] = $this->stringVal($model->date_of_visit);
			$arr["status"] = $this->integerVal($model->realized);
            return $arr;
        }
    }
	
	public function fetchVisitObject($model) {
        if (count($model) == 0) {
            return new stdClass();
        } else {
            $arr = array();
            $arr["id"] = $this->integerVal($model->id);
            $arr["title"] = $this->stringVal($model->title);
            $arr["babyId"] = $this->integerVal($model->baby_id);
            $arr["babyName"] = $this->stringVal($model->baby->username);
            $arr["userId"] = $this->integerVal($model->user_id);
            $arr["userName"] = $this->stringVal($model->user->username);
            $arr["doctorId"] = $this->integerVal($model->doctor_id);
            $arr["doctorName"] = $this->stringVal($model->doctor->username);
            $arr["medication"] = $this->stringVal($model->medication);
			$arr["desage"] = $this->stringVal($model->desage);
			$arr["bageOn"] = $this->stringVal($model->bage_on);
			$arr["frequency"] = $this->stringVal($model->frequency);
			$arr["note"] = $this->stringVal($model->note);
			$arr["prescription"] = $this->stringVal($this->PROJECT_URL.'/media/babies/'.$model->prescription);
            $arr["diagonise"] = $this->stringVal($model->diagonise);
            $arr["date"] = $this->stringVal($model->date_of_visit);
            return $arr;
        }
    }

    public function fetchVaccineObject($model, $flag=1) {
        if (count($model) == 0) {
            return new stdClass();
        } else {
            $arr = array();
            $arr["id"] = $this->integerVal($model->id);
            $arr["title"] = $this->stringVal($model->title);
            $arr["description"] = $this->stringVal($model->desc);
			if($flag){
				$arr["babyId"] = $this->integerVal($model->baby_id);
				$arr["babyName"] = $this->stringVal($model->baby->username);
				$arr["userId"] = $this->integerVal($model->user_id);
				$arr["userName"] = $this->stringVal($model->user->username);
			}
            $arr["date"] = $this->stringVal($model->date_of_vaccine);
            $arr["nextVaccineName"] = $this->stringVal($model->nextVaccine->title);
            $arr["nextVaccineDate"] = $this->stringVal($model->nextVaccine->date_of_vaccine);
            $arr["nextVaccineDescription"] = $this->stringVal($model->nextVaccine->desc);
			$arr["status"] = $this->integerVal($model->realized);
            return $arr;
        }
    }

    public function fetchCommentObject($comment) {
        if (count($comment) == 0) {
            return new stdClass();
        } else {
            $arr = array();
            $arr["id"] = $this->integerVal($comment->id);
            $arr["comment"] = $this->stringVal($comment->comment);
            $arr["userId"] = $this->integerVal($comment->user_id);
            $arr["commentDate"] = $this->stringVal($comment->date_created);
            return $arr;
        }
    }

    public function responseWithMessage($message) {
        $response['message'] = $message;
        echo json_encode($response);
        die;
    }

    public function actionLogin() {
        try {
            $request = $this->parseRequest();
            if ($request != false) {
                if (!$request['email']) {
                    $this->responseWithMessage($this->WRONG_EMAIL);
                } elseif (!$request['password']) {
                    $this->responseWithMessage($this->WRONG_PASSWORD);
                }
                $user = User::model()->findByAttributes(array('email' => $request["email"]));
                if ($user && password_verify($request['password'], $user->password)) {
                    $arr = $this->fetchUserObject($user);
                    $response["message"] = $this->MESSAGE_SUCCESS;
                    $response["user"] = $arr;
                } else {
                    $this->responseWithMessage($this->MESSAGE_ACCESS_DENIED);
                }
                //echo json_encode($response, JSON_NUMERIC_CHECK);
                echo json_encode($response, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
            }
        } catch (Exception $ex) {
            //echo $ex;
            $this->responseWithMessage($this->MESSAGE_FAIL_EX);
        }
    }

    public function actionRegister() {
        try {
            $request = $this->parseRequest();
            if ($request != false) {
                if ($request['socialProvider'] != '' && $request['socialIdentifier'] != '') {
                    //$user = User::model()->findByAttributes(array('social_provider' => strtolower($request['socialProvider']), 'social_identifier' => $request['socialIdentifier'], 'active' => 1));
					$user = User::model()->find(array('condition'=>'active=1 and email="'.$request['email'].'"'));
                    if ($user) {
                        $arr = $this->fetchUserObject($user);
                        $response["message"] = $this->MESSAGE_SUCCESS;
                        $response["user"] = $arr;
                        //echo json_encode($response, JSON_NUMERIC_CHECK);
                        echo json_encode($response, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
                    } elseif(is_integer($request['socialIdentifier']) && isset($request['socialProvider'])) {
                        $model = new User;
                        $model->email = $request["email"];
                        $model->fname = $request["firstName"];
                        $model->lname = $request["lastName"];
                        $model->username = $request["firstName"] . ' ' . $request["lastName"];
						if($request['password'])
                        	$model->password = strtolower($request['password']);
						else
							$model->password = 'new';
                        $model->image = $request["image"];
                        $model->gender = $request["gender"];
                        $model->phone = $request["phone"];
                        $model->active = 1;
                        $model->groups_id = 1;  // normal user
                        $model->social_identifier = $request['socialIdentifier'];
                        $model->social_provider = strtolower($request['socialProvider']);
                        if ($model->save(false)) {
                            $arr = $this->fetchUserObject($model);
                            $response["message"] = $this->MESSAGE_SUCCESS;
                            $response["user"] = $arr;
                            //echo json_encode($response, JSON_NUMERIC_CHECK);
                            echo json_encode($response, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
                        } else {
                            $model->delete();
                            $this->responseWithMessage($this->MESSAGE_FAIL);
                        }
                    }
                } else {
                    if ($request["email"] == '' && $request["password"] == '') {
                        $this->responseWithMessage($this->MESSAGE_REGISTERED_EMPTY);
                    }
                    $this->checkUserDataFound('email', $request["email"]);

                    $model = new User;
                    $model->email = $request["email"];
                    $model->password = $request["password"];
                    $model->fname = $request["firstName"];
                    $model->lname = $request["lastName"];
                    $model->username = $request["firstName"] . ' ' . $request["lastName"];
                    $model->date_of_birth = $request["birthday"];
                    $model->gender = $request["gender"];
                    $model->phone = $request["phone"];
                    if($request["country"]){
                        $country_id='';
                        $country_id=AllCountries::model()->findByAttributes(array('country_code'=>  strtoupper($request["country"])))->id;
                        $model->country = $country_id;
                    }
                    $model->active = 1;
                    $model->groups_id = 1;  // normal user
                    if ($model->save()) {
                        $arr = $this->fetchUserObject($model);
                        $response["message"] = $this->MESSAGE_SUCCESS;
                        $response["user"] = $arr;
                        //echo json_encode($response, JSON_NUMERIC_CHECK);
                        echo json_encode($response, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
                    } else {
                        $model->delete();
                        $this->responseWithMessage($this->MESSAGE_FAIL);
                    }
                }
            }
        } catch (Exception $ex) {
            $this->responseWithMessage($this->MESSAGE_FAIL_EX);
        }
    }

    public function actionUsers() {
        try {
            $request = $this->parseRequest();
            if ($request != false) {
                if (!$request['userId']) {
                    $this->responseWithMessage($this->MESSAGE_ERROR);
                }
                $user = User::model()->findByPk($request["userId"]);
                if ($user) {
                    $arr = $this->fetchUserObject($user);
                    $response["message"] = $this->MESSAGE_SUCCESS;
                    $response["user"] = $arr;
                } else {
                    $this->responseWithMessage($this->USER_NOTFOUND);
                }
                //echo json_encode($response, JSON_NUMERIC_CHECK);
                echo json_encode($response, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
            }
        } catch (Exception $ex) {
            $this->responseWithMessage($this->MESSAGE_FAIL_EX);
        }
    }

    public function actionBabies() {
        try {
            $request = $this->parseRequest();
            if ($request != false) {
                if (!$request['userId']) {
                    $this->responseWithMessage($this->MESSAGE_ERROR);
                }
                $user = User::model()->findByPk($request["userId"]);
                if ($user) {
                    $babies = Baby::model()->findAllByAttributes(array('user_id' => $request["userId"]));
                    if ($babies) {
                        foreach ($babies as $baby) {
                            $arr[] = $this->fetchBabyObject($baby);
                        }
                        $response["message"] = $this->MESSAGE_SUCCESS;
                        $response["babies"] = $arr;
                    } else {
                        //$this->responseWithMessage($this->USER_NOTFOUND);
                        $response["message"] = $this->MESSAGE_SUCCESS;
                        $response["babies"] = array();
                    }
                } else {
                    $this->responseWithMessage($this->USER_NOTFOUND);
                }
                //echo json_encode($response, JSON_NUMERIC_CHECK);
                echo json_encode($response, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
            }
        } catch (Exception $ex) {
            $this->responseWithMessage($this->MESSAGE_FAIL_EX);
        }
    }

    public function actionGetBaby() {
        try {
            $request = $this->parseRequest();
            if ($request != false) {
                if (!$request['userId'] || !$request['babyId']) {
                    $this->responseWithMessage($this->MESSAGE_ERROR);
                }
                $baby = Baby::model()->findByAttributes(array('user_id' => $request["userId"], 'id' => $request['babyId']));
                if ($baby) {
                    $arr = $this->fetchBabyObject($baby);
                    $response["message"] = $this->MESSAGE_SUCCESS;
                    $response["baby"] = $arr;
                } else {
                    $this->responseWithMessage("baby_not_found");
                }
                //echo json_encode($response, JSON_NUMERIC_CHECK);
                echo json_encode($response, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
            }
        } catch (Exception $ex) {
            $this->responseWithMessage($this->MESSAGE_FAIL_EX);
        }
    }

    public function actionCreateBaby() {
        try {
            $request = $this->parseRequest();
            if ($request != false) {
                if (!$request['userId']) {
                    $this->responseWithMessage($this->MESSAGE_ERROR);
                }
                if (User::model()->findByPk($request['userId'])) {
                    $baby = new Baby;
                    $baby->username = $request['babyName'] ? $request['babyName'] : $request['firstName'] . ' ' . $request['lastName'];
                    //$baby->first_name = $request['firstName'];
                    //$baby->last_name = $request['lastName'];
                    $baby->gender = $request['gender'];
                    $baby->user_id = $request['userId'];
                    $baby->date_of_birth = $request['birthday'] . ' ' . $request['birthTime'] . ':00';
                    $baby->birth_place = $request['birthPlace'];
                    $baby->date_of_pergacy = $request['pregnacyTime'];
                    $baby->sun_sign = $request['sunSign'];
                    $baby->blood_type = $request['bloodType'];
                    $baby->height = $request['height'];
                    $baby->weight = $request['weight'];
                    $baby->image = $request['image'];
                    if ($baby->save()) {
                        $arr = $this->fetchBabyObject($baby);
                        $response["message"] = $this->MESSAGE_SUCCESS;
                        $response["baby"] = $arr;
                    }
                } else {
                    $this->responseWithMessage($this->USER_NOTFOUND);
                }
                //echo json_encode($response, JSON_NUMERIC_CHECK);
                echo json_encode($response, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
            }
        } catch (Exception $ex) {
            $this->responseWithMessage($this->MESSAGE_FAIL_EX);
        }
    }

    public function actionUpdateBaby() {
        try {
            $request = $this->parseRequest();
            if ($request != false) {
                if (!$request['userId']) {
                    $this->responseWithMessage($this->MESSAGE_ERROR);
                }
                if ($baby = Baby::model()->findByAttributes(array('user_id' => $request['userId'], 'id' => $request['babyId']))) {
                    $baby->username = $request['babyName'];
                    //$baby->first_name = $request['firstName'];
                    //$baby->last_name = $request['lastName'];
                    $baby->gender = $request['gender'];
                    $baby->user_id = $request['userId'];
                    $baby->date_of_birth = $request['birthday'] . ' ' . $request['birthTime'] . ':00';
                    $baby->birth_place = $request['birthPlace'];
                    $baby->date_of_pergacy = $request['pregnacyTime'];
                    $baby->sun_sign = $request['sunSign'];
                    $baby->image = $request['image'];
                    $baby->banner = $request['banner'];
                    $baby->height = $request['height'];
                    $baby->weight = $request['weight'];
                    $baby->blood_type = $request['bloodType'];
                    if ($baby->save()) {
                        $arr = $this->fetchBabyObject($baby);
                        $response["message"] = $this->MESSAGE_SUCCESS;
                        $response["baby"] = $arr;
                    }
                } else {
                    $this->responseWithMessage($this->USER_NOTFOUND);
                }
                //echo json_encode($response, JSON_NUMERIC_CHECK);
                echo json_encode($response, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
            }
        } catch (Exception $ex) {
            $this->responseWithMessage($this->MESSAGE_FAIL_EX);
        }
    }

    public function actionForgetPassword() {
        try {
            $request = $this->parseRequest();
            if ($request != false) {
                $email = strtolower(trim($request["email"]));
                $criteria = new CDbCriteria();
                $criteria->condition = ' lower(email) = "' . $email . '"';
                $user = User::model()->find($criteria);
                if ($user === null) {
                    $response["message"] = $this->MESSAGE_FAIL_EX;
                } else {
                    $mail = new YiiMailer();
                    $mail->setFrom(Yii::app()->params['adminEmail'], Yii::app()->name . '  Admininstrator');
                    $mail->setTo($email);
                    $mail->setSubject('Forget password');
                    $message = '
                                        <br/>
                                        User account information in ' . Yii::app()->name . '  <br/>
                                        ________________________________________<br/>
                                        Username:  ' . $user->username . '<br/>
                                        Password:   ' . $user->simple_decrypt($user->password) . '<br/>
                                        ';
                    $mail->setBody($message);
                    if ($mail->send()) {
                        $response["message"] = $this->MESSAGE_SUCCESS;
                    } else {
                        $response["message"] = $this->MESSAGE_FAIL_EX;
                    }
                }
                //echo json_encode($response, JSON_NUMERIC_CHECK);
                echo json_encode($response, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
            }
        } catch (Exception $ex) {
            echo $ex;
            $this->responseWithMessage($this->MESSAGE_FAIL_EX);
        }
    }

    public function actionEditProfile() {
        try {
            $request = $this->parseRequest();
            if ($request != false) {
                $edit_user = User::model()->findByPk($request['userId']);
                if ($edit_user) {
                    $edit_user->username = $request['username'] ? $request['username'] : ($edit_user->username ? $edit_user->username : $request['firstName'] . ' ' . $request['lastName']);
                    $edit_user->fname = $request['firstName'];
                    $edit_user->lname = $request['lastName'];
                    $edit_user->gender = $request['gender'];
                    $edit_user->date_of_birth = $request['birthday'];
                    $edit_user->phone = $request['phone'];
                    $edit_user->image = $request['image'];
                    if($request["country"]){
                        $country_id='';
                        $country_id=AllCountries::model()->findByAttributes(array('country_code'=>  strtoupper($request["country"])))->id;
                        $edit_user->country = $country_id;
                    }
                    if ($edit_user->save(false)) {
                        $arr = $this->fetchUserObject($edit_user);
                        $response["message"] = $this->MESSAGE_SUCCESS;
                        $response["user"] = $arr;
                        //echo json_encode($response, JSON_NUMERIC_CHECK);
                        echo json_encode($response, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
                    } else {
                        $this->responseWithMessage($this->MESSAGE_FAIL_EX);
                    }
                } else {
                    $this->responseWithMessage($this->USER_NOTFOUND);
                }
            }
        } catch (Exception $ex) {
            echo $ex;
            $this->responseWithMessage($this->MESSAGE_FAIL_EX);
        }
    }

    public function actionStaticPages() {
        try {
            // 1 => "terms of service", 2 => "about" , 3 => "privacy policy"
            $request = $this->parseRequest();
            if ($request != false) {
                $page = Pages::model()->findByPk($request['flag']);
                $size = $request['mobileSize'];
                if ($page) {
                    $response["message"] = $this->MESSAGE_SUCCESS;
                    $response["title"] = $this->stringVal($page->title);
                    $response["intro"] = $this->stringVal($page->intro);
                    $this->widget('ext.SAImageDisplayer', array(
                        'image' => $page->image,
                        'size' => $size,
                        'title' => 'My super title',
                        'defaultImage' => "defualt.jpg",
                        'originalFolderName' => 'pages',
                    ));
                    $response["image"] = $this->stringVal($page->image);
                    $response["details"] = $this->stringVal($page->details);

                    //echo json_encode($response, JSON_NUMERIC_CHECK);
                    echo json_encode($response, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
                } else {
                    $this->responseWithMessage($this->NOTFOUNDPAGE);
                }
            }
        } catch (Exception $ex) {
            echo $ex;
            $this->responseWithMessage($this->MESSAGE_FAIL_EX);
        }
    }

    public function actionSendMessage() {
        try {
            $request = $this->parseRequest();
            if ($request != false) {
                $name = $request['name'];
                $subject = $request['content'];
                $email = $request['email'];
                if ($email AND $subject AND $name) {
                    $name = '=?UTF-8?B?' . base64_encode($name) . '?=';
                    $subject = '=?UTF-8?B?' . base64_encode($subject) . '?=';
                    $headers = "From: $name <{$email}>\r\n" .
                            "Reply-To: {$email}\r\n" .
                            "MIME-Version: 1.0\r\n" .
                            "Content-type: text/plain; charset=UTF-8";

                    if (mail(Yii::app()->params['email'], $subject, $subject, $headers)) {
                        $this->responseWithMessage($this->MESSAGE_SUCCESS);
                    } else {
                        $this->responseWithMessage("ERROR OCCURED WHILE SENDING EMAIL, PLEASE TRY AGAIN LATER");
                    }
                }
            }
        } catch (Exception $ex) {
            echo $ex;
            $this->responseWithMessage($this->MESSAGE_FAIL_EX);
        }
    }

    public function actionUpload() {
        try {
            $request = $this->parseRequest();
            if ($request != false) {
                $fileData = $request['fileData'];
                $fileName = time() . '-' . $request['fileName'];
                $filePath = Yii::app()->basePath . '/../media' . $request['filePath'] . '/' . $fileName;
                // decode binary data
                $decoded = base64_decode($fileData);

                // write data
                $fp = fopen($filePath, 'wb');
                if (!fwrite($fp, $decoded)) {
                    $this->responseWithMessage($this->MESSAGE_FAIL);
                    die();
                }
                fclose($fp);
                //header('Content-Type: application/json');
                $response["message"] = $this->MESSAGE_SUCCESS;
                $response["fileName"] = $fileName;
                $response["fullPath"] = Yii::app()->getBaseUrl(true) . '/media' . $request['filePath'] . '/' . $fileName;
                //echo json_encode($response, JSON_NUMERIC_CHECK);
                echo json_encode($response, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
            }
        } catch (Exception $ex) {
            $this->responseWithMessage($this->MESSAGE_FAIL_EX);
        }
    }

    /* public function actionUploadFile() {
      try {
      $request = $this->parseRequest();
      if ($request != false) {
      if ($request['model'] == 'user') {
      $file = file_get_contents($request['file']);
      //file_put_contents($filename, $file)/baby/media/croppic/croppedimg/$file['name'];
      } elseif ($request['model'] == 'baby') {

      }
      }
      } catch (Exception $ex) {
      echo $ex;
      $this->responseWithMessage($this->MESSAGE_FAIL_EX);
      }
      } */

    public function actionGetPost() {
        try {
            $request = $this->parseRequest();
            if ($request != false) {
                if ($request['id']) {
                    $model = Post::model()->findByPk($request['id']);
                    if ($model) {
                        $arr = $this->fetchPostObject($model);
                        $response["message"] = $this->MESSAGE_SUCCESS;
                        $response["post"] = $arr;
                        echo json_encode($response, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
                    } else {
                        $this->responseWithMessage("Post not found.");
                    }
                } else {
                    $this->responseWithMessage($this->MESSAGE_FAIL_EX);
                }
            }
        } catch (Exception $ex) {
            $this->responseWithMessage($this->MESSAGE_FAIL_EX);
        }
    }

    public function actionNewPost() {
        try {
            $request = $this->parseRequest();
            if ($request != false) {
                $model = new Post;
                if (isset($request['babyId'])) {
                    $model->baby_id = $request['babyId'];
                }
                if (isset($request['groupId'])) {
                    $model->group_id = $request['groupId'];
                }
                if (isset($request['userId']) && (($model->group_id != '' && Group::IsGroupAccess($model->group_id, $request['userId'])) || ($model->baby_id != '' && Baby::IsBabyAccess($model->baby_id, $request['userId'])))) {
                    $model->user_id = $request['userId'];
                    $model->baby_id = $request['babyId'];
                    $model->group_id = $request['groupId'];
                    $model->content = $request['content'];

                    if (isset($request['images']) && count($request['images']) > 1) {
                        if (isset($request['isVideo']) && $request['isVideo'] == 2) {
                            $album = new Album;
                            $album->title = $request['title'];
                            $album->date_of_album = date('Y-m-d');
                            $album->user_id = $request['userId'];
                            if ($model->baby_id) {
                                $album->baby_id = $model->baby_id;
                            } elseif ($model->group_id) {
                                $album->group_id = $model->group_id;
                            }
                            $album->save();
                            $model->album_id = $album->id; // save the album and put the album id in the post
                        } else {
                            $album = Album::model()->findByAttributes(array('first_album' => '1', 'user_id' => $request['userId']));
                        }
                        $sub_album = $model->baby_id ? Album::model()->findByAttributes(array('first_album' => '1', 'baby_id' => $model->baby_id)) : Album::model()->findByAttributes(array('first_album' => '1', 'group_id' => $model->group_id));

                        if ($model->save()) {
                            foreach ($request['images'] as $i => $img) {
                                $albumImg = new AlbumImage;
                                $albumImg->album_id = $album->id;
                                if ($i == 0)
                                    $albumImg->main_pic = 1;

                                $albumImg->image = $img;
                                if ($albumImg->save()) {
                                    $albumImg->isNewRecord = true;
                                    $albumImg->album_id = $sub_album->id;
                                    $albumImg->id = NULL;
                                    $albumImg->save(); //save the image into the user album and the baby or group album too
                                    $media = new PostMedia;
                                    $media->post_id = $model->id;
                                    $media->media = $img;
                                    $media->save();
                                }
                            }
                        }
                    } else {
                        if (isset($request['isVideo']) && $request['isVideo'] == 1) {
                            $model->video = $request['images'][0];
                        } else {
                            $model->image = $request['images'][0];
                        }
                    }

                    $model->save(false);
                    $arr = $this->fetchPostObject($model);
                    $response["message"] = $this->MESSAGE_SUCCESS;
                    $response["post"] = $arr;
                    echo json_encode($response, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
                } else {
                    $this->responseWithMessage("You can only post to a baby profile or a group page.");
                }
            }
        } catch (Exception $ex) {
            $this->responseWithMessage($this->MESSAGE_FAIL_EX);
        }
    }

    public function actionGetPosts() {
        try {
            $request = $this->parseRequest();
            if ($request != false) {
                if (isset($request['userId']) && isset($request['offset']) && isset($request['limit'])) {
                    $posts = array();
                    if (!isset($request['babyId']) && !isset($request['groupId'])) {
                        if (isset($request['friends']) && $request['friends'] == 1) {
                            $posts = Post::model()->findAllBySql('select * from post where user_id=' . $request['userId'] . ' or 
							(
									user_id in (select user_id from user_friend where friend_id=' . $request['userId'] . '  and approved=1 and date_created <= `post`.date_created) or 
									user_id in (select friend_id from user_friend where user_id=' . $request['userId'] . ' and approved=1 and date_created <= `post`.date_created)
							) or 
							(
									group_id in (select id from `group` where user_id=' . $request['userId'] . ' or id in (select group_id from group_user where user_id=' . $request['userId'] . ' and date_created <= `post`.date_created))
							) order by id desc limit ' . $request['offset'] . ',' . $request['limit']);
                        } else {
                            $posts = Post::model()->findAll(array('condition' => 'user_id=' . $request['userId'], 'order' => 'id desc', 'offset' => $request['offset'], 'limit' => $request['limit']));
                        }
                    } elseif (isset($request['babyId'])) {
                        $posts = Post::model()->findAll(array('condition' => 'baby_id=' . $request['babyId'], 'order' => 'id desc', 'offset' => $request['offset'], 'limit' => $request['limit']));
                    } elseif (isset($request['groupId'])) {
                        $posts = Post::model()->findAll(array('condition' => 'group_id=' . $request['groupId'], 'order' => 'id desc', 'offset' => $request['offset'], 'limit' => $request['limit']));
                    }

                    if ($posts) {
                        foreach ($posts as $post) {
                            $arr = $this->fetchPostObject($post);
                            $response["posts"][] = $arr;
                        }
                        $response["message"] = $this->MESSAGE_SUCCESS;
                        echo json_encode($response, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
                    } else {
                        $this->responseWithMessage("No posts found.");
                    }
                } else {
                    $this->responseWithMessage($this->MESSAGE_FAIL_EX);
                }
            }
        } catch (Exception $ex) {
            $this->responseWithMessage($this->MESSAGE_FAIL_EX);
        }
    }

    public function actionFavorite() {
        try {
            $request = $this->parseRequest();
            if ($request != false) {
                if (isset($request['userId']) && isset($request['id']) && isset($request['type'])) {
                    if ($request['type'] == 'post')
                        $type = 1;
                    elseif ($request['type'] == 'album')
                        $type = 2;
                    elseif ($request['type'] == 'albumImage')
                        $type = 3;
                    elseif ($request['type'] == 'user')
                        $type = 4;
                    elseif ($request['type'] == 'baby')
                        $type = 5;
                    $id = $request['id'];
                    $fav = Favourite::model()->findByAttributes(array('user_id' => $request['userId'], 'item_type' => $type, 'item_id' => $id));
                    if ($fav) {
                        if ($fav->delete())
                            $status = 2;
                    }
                    else {
                        $fav = new Favourite;
                        $fav->item_id = $id;
                        $fav->item_type = $type;
                        $fav->user_id = $request['userId'];
                        if ($fav->save(false))
                            $status = 1;
                    }
                    $favs = Favourite::model()->findAllByAttributes(array('item_type' => $type, 'item_id' => $id));
                    $response["message"] = $this->MESSAGE_SUCCESS;
                    $response['status'] = $status;
                    $response['count'] = count($favs);
                    echo json_encode($response, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
                }else {
                    $this->responseWithMessage($this->MESSAGE_FAIL_EX);
                }
            }
        } catch (Exception $ex) {
            $this->responseWithMessage($this->MESSAGE_FAIL_EX);
        }
    }

    public function actionLike() {
        try {
            $request = $this->parseRequest();
            if ($request != false) {
                if (isset($request['userId']) && isset($request['id']) && isset($request['type'])) {
                    if ($request['type'] == 'post')
                        $type = 1;
                    elseif ($request['type'] == 'album')
                        $type = 2;
                    elseif ($request['type'] == 'albumImage')
                        $type = 3;
                    elseif ($request['type'] == 'user')
                        $type = 4;
                    elseif ($request['type'] == 'baby')
                        $type = 5;
                    $id = $request['id'];
                    $fav = Like::model()->findByAttributes(array('user_id' => $request['userId'], 'item_type' => $type, 'item_id' => $id));
                    if ($fav) {
                        if ($fav->delete())
                            $status = 2;
                    }
                    else {
                        $fav = new Like;
                        $fav->item_id = $id;
                        $fav->item_type = $type;
                        $fav->user_id = $request['userId'];
                        if ($fav->save(false))
                            $status = 1;
                    }
                    $favs = Like::model()->findAllByAttributes(array('item_type' => $type, 'item_id' => $id));
                    $response['status'] = $status;
                    $response["message"] = $this->MESSAGE_SUCCESS;
                    $response['count'] = count($favs);
                    echo json_encode($response, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
                }else {
                    $this->responseWithMessage($this->MESSAGE_FAIL_EX);
                }
            }
        } catch (Exception $ex) {
            $this->responseWithMessage($this->MESSAGE_FAIL_EX);
        }
    }

    public function actionGetComments() {
        try {
            $request = $this->parseRequest();
            if ($request != false) {
                if (isset($request['id']) && isset($request['type'])) {

                    if ($request['type'] == 'post')
                        $type = 1;
                    elseif ($request['type'] == 'album')
                        $type = 2;
                    elseif ($request['type'] == 'albumImage')
                        $type = 3;
                    elseif ($request['type'] == 'user')
                        $type = 4;
                    elseif ($request['type'] == 'baby')
                        $type = 5;

                    $comments = Comment::model()->findAllByAttributes(array('item_id' => $request['id'], 'item_type' => $type));
                    $response["comments"] = array();
                    if ($comments) {
                        foreach ($comments as $comment) {
                            $arr = $this->fetchCommentObject($comment);
                            $response["comments"][] = $arr;
                        }
                    }

                    $response["message"] = $this->MESSAGE_SUCCESS;
                    $response['count'] = count($comments);
                    echo json_encode($response, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
                } else {
                    $this->responseWithMessage($this->MESSAGE_FAIL_EX);
                }
            }
        } catch (Exception $ex) {
            $this->responseWithMessage($this->MESSAGE_FAIL_EX);
        }
    }

    public function actionAddComment() {
        try {
            $request = $this->parseRequest();
            if (isset($request['userId']) && isset($request['id']) && isset($request['comment']) && isset($request['type'])) {
                if ($request['type'] == 'post')
                    $type = 1;
                elseif ($request['type'] == 'album')
                    $type = 2;
                elseif ($request['type'] == 'albumImage')
                    $type = 3;
                elseif ($request['type'] == 'user')
                    $type = 4;
                elseif ($request['type'] == 'baby')
                    $type = 5;
                $comment = new Comment;
                $comment->user_id = $request['userId'];
                $comment->comment = $request['comment'];
                $comment->item_id = $request['id'];
                $comment->item_type = $type;
                if ($comment->save()) {
                    $response["message"] = $this->MESSAGE_SUCCESS;
                    $response['comment'] = $this->fetchCommentObject($comment);
                    echo json_encode($response, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
                }
            } else {
                $this->responseWithMessage("Missing Parameters");
            }
        } catch (Exception $ex) {
            $this->responseWithMessage($this->MESSAGE_FAIL_EX);
        }
    }

    /*     * ******************3/3/2015********************** */

    public function actionChangePassword() {
        try {
            $request = $this->parseRequest();
            if (isset($request['id']) && isset($request['old_password']) && isset($request['password']) && isset($request['password_repeat'])) {
                $model = User::model()->findByPk($request['id']);
                if (!password_verify($request['old_password'], $model->password)) {
                    $response["message"] = $this->WRONG_PASSWORD;
                } elseif ($request['password_repeat'] != $request['password']) {
                    $response["message"] = "Password mismatch.";
                } else {
                    $model->password = password_hash($request['password'], PASSWORD_BCRYPT);
                    $model->save(false);
                    $response["message"] = $this->MESSAGE_SUCCESS;
                }
                echo json_encode($response, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
            } else {
                $this->responseWithMessage("Missing Parameters");
            }
        } catch (Exception $ex) {
            $this->responseWithMessage($this->MESSAGE_FAIL_EX);
        }
    }

    public function actionDoctorsAndHospitals() {
        try {
            $request = $this->parseRequest();
            if ($request != false) {
                if (!$request['flag']) {
                    $this->responseWithMessage($this->MESSAGE_ERROR);
                }
                $users = User::model()->findAll(array('condition' => 'groups_id=2 or groups_id=3'));
                $arr = array();
                if ($users) {
                    foreach ($users as $us) {
                        $arr[] = $this->fetchUserObject($us);
                    }
                }
                $response["message"] = $this->MESSAGE_SUCCESS;
                $response["users"] = $arr;
                echo json_encode($response, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
            }
        } catch (Exception $ex) {
            $this->responseWithMessage($this->MESSAGE_FAIL_EX);
        }
    }
	
	public function actionGetDoctors() {
        try {
            $request = $this->parseRequest();
            if ($request != false) {
                if (!$request['flag']) {
                    $this->responseWithMessage($this->MESSAGE_ERROR);
                }
				$more='';
				if($request['country']!=''){
					$country_id=AllCountries::model()->findByAttributes(array('country_code'=>  strtoupper($request["country"])))->id;
					$more=' and country="'.$country_id.'"';
				}
                $users = User::model()->findAll(array('condition' => 'groups_id=2'.$more));
                $arr = array();
                if ($users) {
                    foreach ($users as $us) {
                        $arr[] = $this->fetchUserObject($us);
                    }
                }
                $response["message"] = $this->MESSAGE_SUCCESS;
                $response["users"] = $arr;
                echo json_encode($response, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
            }
        } catch (Exception $ex) {
            $this->responseWithMessage($this->MESSAGE_FAIL_EX);
        }
    }
	
	public function actionGetHospitals() {
        try {
            $request = $this->parseRequest();
            if ($request != false) {
                if (!$request['flag']) {
                    $this->responseWithMessage($this->MESSAGE_ERROR);
                }
				$more='';
				if($request['country']!=''){
					$country_id=AllCountries::model()->findByAttributes(array('country_code'=>  strtoupper($request["country"])))->id;
					$more=' and country="'.$country_id.'"';
				}
                $users = User::model()->findAll(array('condition' => 'groups_id=3'.$more));
                $arr = array();
                if ($users) {
                    foreach ($users as $us) {
                        $arr[] = $this->fetchUserObject($us);
                    }
                }
                $response["message"] = $this->MESSAGE_SUCCESS;
                $response["users"] = $arr;
                echo json_encode($response, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
            }
        } catch (Exception $ex) {
            $this->responseWithMessage($this->MESSAGE_FAIL_EX);
        }
    }

    public function actionUserFriends() {
        try {
            $request = $this->parseRequest();
            if ($request != false) {
                if ($request['id']) {
                    $users = User::model()->findAllBySql('select * from user where id!=' . $request['id'] . ' and (id in (select user_id from user_friend where friend_id=' . $request['id'] . '  and approved=1) or id in (select friend_id from user_friend where user_id=' . $request['id'] . ' and approved=1))');
                    $arr = array();
                    if ($users) {
                        foreach ($users as $us) {
                            $arr[] = $this->fetchUserObject($us);
                        }
                    }
                    $response["message"] = $this->MESSAGE_SUCCESS;
                    $response["users"] = $arr;
                    echo json_encode($response, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
                } else {
                    $this->responseWithMessage($this->MESSAGE_ERROR);
                }
            }
        } catch (Exception $ex) {
            $this->responseWithMessage($this->MESSAGE_FAIL_EX);
        }
    }

    public function actionCreateGroup() {
        try {
            $request = $this->parseRequest();
            if ($request != false) {
                $model = new Group;
                $model->user_id = $request['userId'];
                $model->title = $request['name'];
                $model->other = $request['description'];
                $model->banner = $request['banner'];
                $model->privacy = $request['privacy']; //1=private
                if ($model->save()) {
                    $response["message"] = $this->MESSAGE_SUCCESS;
                    $response["group"] = $this->fetchGroupObject($model);
                }
                echo json_encode($response, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
            }
        } catch (Exception $ex) {
            $this->responseWithMessage($this->MESSAGE_FAIL_EX);
        }
    }

    public function actionGetGroup() {
        try {
            $request = $this->parseRequest();
            if ($request != false) {
                $model = Group::model()->findByPk($request['id']);
                if ($model) {
                    $response["message"] = $this->MESSAGE_SUCCESS;
                    $response["group"] = $this->fetchGroupObject($model);
                }
                echo json_encode($response, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
            }
        } catch (Exception $ex) {
            $this->responseWithMessage($this->MESSAGE_FAIL_EX);
        }
    }

    public function actionJoinGroup() {
        try {
            $request = $this->parseRequest();
            if ($request != false) {
                $model = new GroupInvitee;
                $model->user_id = $request['userId'];
                $model->group_id = $request['groupId'];
                $model->status = 1;
                $model->save(false);
                $response["message"] = $this->MESSAGE_SUCCESS;
                echo json_encode($response, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
            }
        } catch (Exception $ex) {
            $this->responseWithMessage($this->MESSAGE_FAIL_EX);
        }
    }

    public function actionInviteGroup() {
        try {
            $request = $this->parseRequest();
            if ($request != false) {
                $model = new GroupInvitee;
                $model->user_id = $request['userId'];
                $model->group_id = $request['groupId'];
                $model->save(false);
                $response["message"] = $this->MESSAGE_SUCCESS;
                echo json_encode($response, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
            }
        } catch (Exception $ex) {
            $this->responseWithMessage($this->MESSAGE_FAIL_EX);
        }
    }

    /*     * ******************17/3/2015********************** */

    public function actionEditGroup() {
        /*         * ****************
         * Link: localhost/firstpout/api/editGroup
         * Request: {
          "id":"3",
          "userId":"27",
          "banner": "/firstpout/media/croppic/croppedimg/croppedImg_1423315944.jpeg",
          "name": "asd",
          "description": "ppp",
          "privacy":1
          }
         * Response: {
          "message": "success",
          "group": {
          "name": "asd",
          "userId": "27",
          "username": "Ahmed Hany",
          "userImage": "/firstpout/media/croppic/croppedimg/croppedImg_1422823948.jpeg",
          "banner": "/firstpout/media/croppic/croppedimg/croppedImg_1423315944.jpeg",
          "privacy": 1,
          "creationDate": "2015-02-07 15:32:38",
          "description": "ppp",
          "invitees": [
          {
          "inviteeId": "28",
          "inviteeName": "Ahmed Hany",
          "inviteeImage": "http://graph.facebook.com/10204175728890575/picture"
          }
          ]
          }
          }
         * 
         * ******************** */
        try {
            $request = $this->parseRequest();
            if ($request != false) {
                if (Group::IsGroupAdmin($request['id'], $request['userId'])) {
                    $model = Group::model()->findByPk($request['id']);
                    $model->title = $request['name'];
                    $model->other = $request['description'];
                    $model->banner = $request['banner'];
                    $model->privacy = $request['privacy']; //1=private
                    if ($model->save()) {
                        $response["message"] = $this->MESSAGE_SUCCESS;
                        $response["group"] = $this->fetchGroupObject($model);
                    }
                } else {
                    $response["message"] = $this->MESSAGE_ACCESS_DENIED;
                }
                echo json_encode($response, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
            }
        } catch (Exception $ex) {
            $this->responseWithMessage($this->MESSAGE_FAIL_EX);
        }
    }

    //give admin access
    public function actionGroupAdminToggle() {
        /**
         * Link: localhost/firstpout/api/GroupAdminToggle 
         * Request: {
          "id":"3",
          "userId":"28",
          "status":0
          }
         * Response: {
          "message":"success"
          }
         * * */
        try {
            $request = $this->parseRequest();
            if ($request != false) {
                $model = GroupUser::model()->findByAttributes(array('group_id' => $request['id'], 'user_id' => $request['userId']));
                if ($model) {
                    $model->role = $request['status']; //1=admin
                    $model->save(false);
                    $response["message"] = $this->MESSAGE_SUCCESS;
                } else {
                    $response["message"] = $this->MESSAGE_ACCESS_DENIED;
                }
                echo json_encode($response, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
            }
        } catch (Exception $ex) {
            $this->responseWithMessage($this->MESSAGE_FAIL_EX);
        }
    }

    public function actionJoinGroupAcceptDecline() {
        //the group admins only can accept or decline the join request
        //this action is working for both invitee and join requests
        /*

         *  Link: localhost/firstpout/api/JoinGroupAcceptDecline
         *  Request: {
          "id":"3",
          "userId":"28",
          "status":1
          }
         * Response: {
          "message": "success"
          }
         *          
         */

        try {
            $request = $this->parseRequest();
            if ($request != false) {
                $model = GroupInvitee::model()->findByAttributes(array('user_id' => $request['userId'], 'group_id' => $request['id']));
                if ($model) {
                    if ($request['status'] == 1) { //1= accept
                        $gu = new GroupUser;
                        $gu->group_id = $model->group_id;
                        $gu->user_id = $model->user_id;
                        $gu->role = 0;
                        $gu->date_joined = date('Y-m-d H:i:s');
                        $gu->save();
                    }
                    GroupInvitee::model()->deleteAllByAttributes(array('user_id' => $request['userId'], 'group_id' => $request['id']));
                    $response["message"] = $this->MESSAGE_SUCCESS;
                } else {
                    $response["message"] = $this->MESSAGE_ACCESS_DENIED;
                }
                echo json_encode($response, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
            }
        } catch (Exception $ex) {
            $this->responseWithMessage($this->MESSAGE_FAIL_EX);
        }
    }

    public function actionSendFriendRequest() {
        /*
         * Link: localhost/firstpout/api/SendFriendRequest
         * Request: {
          "userId":"27",
          "friendId":"28"
          }
         * Response: {"message":"success"}
         */

        try {
            $request = $this->parseRequest();
            if ($request != false) {
                $model = UserFriend::model()->findByAttributes(array('user_id' => $request['userId'], 'friend_id' => $request['friendId']));
                if ($model) {
                    $response["message"] = $this->MESSAGE_ACCESS_DENIED;
                } else {
                    $model = new UserFriend;
                    $model->user_id = $request['userId'];
                    $model->friend_id = $request['friendId'];
                    $model->approved = 0;
                    $model->save();
                    $response["message"] = $this->MESSAGE_SUCCESS;
                }
                echo json_encode($response, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
            }
        } catch (Exception $ex) {
            $this->responseWithMessage($this->MESSAGE_FAIL_EX);
        }
    }

    public function actionAcceptDeclineFriendRequest() {
        /*
         * Link: localhost/firstpout/api/AcceptDeclineFriendRequest
         * Request: {
          "userId":"27",
          "friendId":"28",
          "status":1
          }
         * Response: {"message":"success"}
         */

        try {
            $request = $this->parseRequest();
            if ($request != false) {
                $model = UserFriend::model()->findByAttributes(array('user_id' => $request['userId'], 'friend_id' => $request['friendId'], 'approved' => 0));
                if ($model) {
                    if ($request['status'] == 1) { //1= accept
                        $model->approved = 1;
                        $model->save();
                    } else {
                        UserFriend::model()->deleteAllByAttributes(array('user_id' => $request['userId'], 'friend_id' => $request['friendId'], 'approved' => 0));
                    }
                    $response["message"] = $this->MESSAGE_SUCCESS;
                } else {
                    $response["message"] = $this->MESSAGE_ACCESS_DENIED;
                }
                echo json_encode($response, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
            }
        } catch (Exception $ex) {
            $this->responseWithMessage($this->MESSAGE_FAIL_EX);
        }
    }

    public function actionCreateAlbum() {
        try {
            $request = $this->parseRequest();
            if ($request != false) {
                $album = new Album;
                $albumImg = new AlbumImage;
                $user = User::model()->findByPk($request['userId']);
                $album->title = $request['title'];
                $album->desc = $request['description'];
                $album->user_id = $request['userId'];
                $album->baby_id = $request['babyId'];
                //$album->group_id = $request['groupId'];
                $album->date_of_album = $request['albumDate']; //Y-m-d
                $album->private = $request['private'];
                //$album->belong_to_me = $request['belongToMe'];

                if ($album->save()) {

                    /**                     * create post to that album** */
                    $post = new Post;
                    $post->user_id = $album->user_id;
                    $post->album_id = $album->id;
                    $post->title = $album->title;
                    $post->content = $album->desc;
                    $post->save(false);
                    $index = 0;
                    $photos = $request['images'];
                    if ($photos && count($photos) > 0) {
                        foreach ($photos as $pic) {
                            $albumImg = new AlbumImage;
                            $albumImg->image = $pic;
                            $albumImg->album_id = $album->id;
                            //$albumImg->date_taken = $_POST['AlbumImage']['date_taken'][$index];
                            if ($index == 0) {
                                $albumImg->main_pic = 1;
                            }
                            $albumImg->save(false); // DONE
                            $media = new PostMedia;
                            $media->post_id = $post->id;
                            $media->media = $pic;
                            $media->save();
                        }
                        $index++;
                    }
                    $response["message"] = $this->MESSAGE_SUCCESS;
                    $response['album'] = $this->fetchAlbumObject($album);
                    echo json_encode($response, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
                } else {
                    $this->responseWithMessage($this->MESSAGE_ERROR);
                }
            } else {
                $this->responseWithMessage($this->MESSAGE_FAIL_EX);
            }
            echo json_encode($response, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
        } catch (Exception $ex) {
            $this->responseWithMessage($this->MESSAGE_FAIL_EX);
        }
    }

    /*     * ***********************************30/4/2015********************************************* */

    public function actionGetAppointments() {
        try {
            $request = $this->parseRequest();
            if ($request != false) {
                if (isset($request['userId']) && isset($request['babyId']) && isset($request['limit']) && isset($request['offset']) && isset($request['order'])) {
                    if (Baby::IsBabyAccess($request['babyId'], $request['userId'])) {
                        $appointments = Appointment::model()->findAll(array('condition' => 'realized=2 and baby_id=' . $request['babyId'], 'order' => 'id ' . $request['order'], 'offset' => $request['offset'], 'limit' => $request['limit']));
                        $response["appointments"] = array();
                        if ($appointments) {
                            foreach ($appointments as $appointment) {
                                $arr = $this->fetchAppointmentObject($appointment);
                                $response["appointments"][] = $arr;
                            }
                        }

                        $response["message"] = $this->MESSAGE_SUCCESS;
                        $response['count'] = count($appointments);
                    } else {
                        $response["message"] = "You don't have access to this section.";
                    }
                    echo json_encode($response, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
                } else {
                    $this->responseWithMessage($this->MESSAGE_FAIL_EX);
                }
            }
        } catch (Exception $ex) {
            $this->responseWithMessage($this->MESSAGE_FAIL_EX);
        }
    }
	
	 public function actionGetVisits() {
        try {
            $request = $this->parseRequest();
            if ($request != false) {
                if (isset($request['userId']) && isset($request['babyId']) && isset($request['limit']) && isset($request['offset']) && isset($request['order'])) {
                    if (Baby::IsBabyAccess($request['babyId'], $request['userId'])) {
                        $visits = Visit::model()->findAll(array('condition' => 'baby_id=' . $request['babyId'], 'order' => 'id ' . $request['order'], 'offset' => $request['offset'], 'limit' => $request['limit']));
                        $response["visits"] = array();
                        if ($visits) {
                            foreach ($visits as $visit) {
                                $arr = $this->fetchVisitObject($visit);
                                $response["visits"][] = $arr;
                            }
                        }

                        $response["message"] = $this->MESSAGE_SUCCESS;
                        $response['count'] = count($visits);
                    } else {
                        $response["message"] = "You don't have access to this section.";
                    }
                    echo json_encode($response, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
                } else {
                    $this->responseWithMessage($this->MESSAGE_FAIL_EX);
                }
            }
        } catch (Exception $ex) {
            $this->responseWithMessage($this->MESSAGE_FAIL_EX);
        }
    }

    public function actionGetVaccines() {
        try {
            $request = $this->parseRequest();
            if ($request != false) {
                if (isset($request['userId']) && isset($request['babyId']) && isset($request['limit']) && isset($request['offset']) && isset($request['order'])) {
                    if (Baby::IsBabyAccess($request['babyId'], $request['userId'])) {
                        $vaccines = Vaccine::model()->findAll(array('condition' => 'baby_id=' . $request['babyId'], 'order' => 'id ' . $request['order'], 'offset' => $request['offset'], 'limit' => $request['limit']));
                        $response["vaccines"] = array();
                        if ($vaccines) {
                            foreach ($vaccines as $vaccine) {
                                $arr = $this->fetchVaccineObject($vaccine);
                                $response["vaccines"][] = $arr;
                            }
                        }

                        $response["message"] = $this->MESSAGE_SUCCESS;
                        $response['count'] = count($vaccines);
                    } else {
                        $response["message"] = "You don't have access to this section.";
                    }
                    echo json_encode($response, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
                } else {
                    $this->responseWithMessage($this->MESSAGE_FAIL_EX);
                }
            }
        } catch (Exception $ex) {
            $this->responseWithMessage($this->MESSAGE_FAIL_EX);
        }
    }
	
	public function actionGetCountryVaccines() {
        try {
            $request = $this->parseRequest();
            if ($request != false) {
				$country_id=AllCountries::model()->findByAttributes(array('country_code'=>  strtoupper($request["country"])))->country_id;
				$vaccines = Vaccine::model()->findAll(array('condition' => 'baby_id is null and country_id='.$country_id));
				$response["vaccines"] = array();
				if ($vaccines) {
					foreach ($vaccines as $vaccine) {
						$arr = $this->fetchVaccineObject($vaccine, 0);
						$response["vaccines"][] = $arr;
					}
				}

				$response["message"] = $this->MESSAGE_SUCCESS;
				$response['count'] = count($vaccines);
				echo json_encode($response, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
			} else {
				$this->responseWithMessage($this->MESSAGE_FAIL_EX);
			}
        } catch (Exception $ex) {
            $this->responseWithMessage($this->MESSAGE_FAIL_EX);
        }
    }
	
	public function actionAddVaccine() {
        try {
            $request = $this->parseRequest();
            if ($request != false) {
				if (Baby::IsBabyAccess($request['babyId'], $request['userId'])) {
					$pre_vaccine=Vaccine::model()->find(array('condition'=>'baby_id='.$request['babyId'].' and user_id='.$request['userId'], 'order'=>'id desc'));
					$model=new Vaccine;
					$model->user_id=$request['userId'];
					$model->baby_id=$request['babyId'];
					$model->title=$request['title'];
					$model->desc=$request['desc'];
					$model->date_of_vaccine=$request['date'];
					$model->realized=$request['status'];
					if($model->save()){
						if($pre_vaccine){
							$pre_vaccine->next_vaccine_id=$model->id;
							$pre_vaccine->save(false);
						}
						$response["message"] = $this->MESSAGE_SUCCESS;
					}
				}else{
					$response["message"] = "You don't have access to this section.";
				}
				echo json_encode($response, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
			}
		} catch (Exception $ex) {
            $this->responseWithMessage($this->MESSAGE_FAIL_EX);
        }
	}
	
	public function actionAddAppointment() {
        try {
            $request = $this->parseRequest();
            if ($request != false) {
				if (Baby::IsBabyAccess($request['babyId'], $request['userId'])) {
					$model=new Appointment;
					$model->user_id=$request['userId'];
					$model->baby_id=$request['babyId'];
					$model->doctor_id=$request['doctorId'];
					$model->hospital_id=$request['hospitalId'];
					$model->title=$request['title'];
					$model->date_of_visit=date('Y-m-d H:i:s', strtotime($request['date']));
					if($request['status'])
						$model->realized=$request['status'];
					if($model->save()){
						$response["message"] = $this->MESSAGE_SUCCESS;
					}
				}else{
					$response["message"] = "You don't have access to this section.";
				}
				echo json_encode($response, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
			}
		} catch (Exception $ex) {
            $this->responseWithMessage($this->MESSAGE_FAIL_EX);
        }
	}
	
	public function actionVaccineStatus(){
		 try {
            $request = $this->parseRequest();
            if ($request != false) {
				if (Baby::IsBabyAccess($request['babyId'], $request['userId'])) {
					$model=Vaccine::model()->findByPk($request['id']);
					$model->realized=$request['status'];
					if($model->save()){
						$response["message"] = $this->MESSAGE_SUCCESS;
					}
				}else{
					$response["message"] = "You don't have access to this section.";
				}
				echo json_encode($response, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
			}
		} catch (Exception $ex) {
            $this->responseWithMessage($this->MESSAGE_FAIL_EX);
        }
	}
	public function actionAppointmentStatus(){
		 try {
            $request = $this->parseRequest();
            if ($request != false) {
				if (Baby::IsBabyAccess($request['babyId'], $request['userId'])) {
					$model=Appointment::model()->findByPk($request['id']);
					$model->realized=$request['status'];
					if($model->save()){
						$response["message"] = $this->MESSAGE_SUCCESS;
					}
				}else{
					$response["message"] = "You don't have access to this section.";
				}
				echo json_encode($response, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
			}
		} catch (Exception $ex) {
            $this->responseWithMessage($this->MESSAGE_FAIL_EX);
        }
	}	

}

?>
