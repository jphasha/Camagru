<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

class Gallery
{
    public $path;
    private $_db;

    public function __construct()
    {
        $this->path = __DIR__ . '/../uploads';
        $this->_db = DB::getInstance();
    }

    public function setPath($path)
    {
        if (substr($path, -1) === '/') // if the last charater is '/';
        {
            $path = substr($path, 0, -1); // remove the last character;
        }
        $this->path = $path;
    }

    public function getImages()
    {
        $imgObj = $this->_db->get('pictures', ['picture_id', '>', 0]); // returns an array of results refer db class
        $i = 0;
        $img = [];

        while ($i < $imgObj->count())
        {
            $img[$i] =  [
                'full' => $this->path . '/' . $imgObj->results()[$i]->picture_name
                // 'thumb' => $this->path . '/thumbs/' . $image
            ];
            $i = $i + 1;
        }
        return (count($img)) ? $img : false;
    }

    public function getImageId()
    {
        $imgIdObj = $this->_db->get('pictures', ['picture_id', '>', 0]);
        $itd = 0;
        $imd = [];

        while ($itd < $imgIdObj->count())
        {
            $imd[$itd] = [
                $itd => $imgIdObj->results()[$itd]->picture_id
            ];
            $itd = $itd + 1;
        }
        return (count($imd)) ? $imd : false;
    }

    public function getLikesCount($imageId)
    {
        return $this->_db->get('likes', ['picture_id', '=', $imageId])->count();
    }

    public function getComments($imageId)
    {
        $comments = $this->_db->get('comments', ['picture_id', '=', $imageId])->results();
        
        return $comments;
    }

    public function getLikes($currentUserId, $imageId)
    {
        $imageLikes = $this->_db->query('SELECT * FROM likes WHERE picture_id = ? AND liker_id = ?', [$imageId, $currentUserId]);

        return $imageLikes->count();
    }

    public function deleteLikes($imageId, $currentUserId)
    {
        return $this->_db->query('DELETE FROM likes WHERE picture_id = ? AND liker_id = ?', [$imageId, $currentUserId]);
    }

    public function likePictures($imageId, $currentUserId)
    {
        return $this->_db->insert('likes',[
            'picture_id' => $imageId,
            'liker_id' => $currentUserId
        ]
    );
    }

    public function getUserPics($userId)
    {
        $imgObj = $this->_db->get('pictures', ['picture_id', '>', 0])->results();
        $itr = 0;
        $it = 0;
        $pictures = [];

        while ($itr < count($imgObj))
        {
            if ($imgObj[$itr]->user_id === $userId)
            {
                $pictures[$it] = [
                    'full' => $this->path . '/' . $imgObj[$itr]->picture_name
                ];
                $it = $it + 1;
            }
            $itr = $itr + 1;
        }
        if (count($pictures))
        {
            return $pictures;
        }
        else
        {
            return false;
        }
    }

    public function insertImage($userId, $imageName)
    {
        return $this->_db->insert('pictures', [
            'user_id' => $userId,
            'picture_name' => $imageName
        ]);
    }

    public function getImageCount()
    {
        return $this->_db->get('pictures', ['picture_id', '>', 0])->count();
    }

    public function getPaginatedImages($starting_point, $images_per_page)
    {
        $imgObj = $this->_db->query('SELECT * FROM pictures LIMIT ' . $starting_point . ',' . $images_per_page);
        $i = 0;
        $img_array = [];

        while ($i < $imgObj->count())
        {
            $img_array[$i] =
            [
                'full' => $this->path . '/' . $imgObj->results()[$i]->picture_name
            ];
            $i = $i + 1;
        }
        if (count($img_array))
        {
            return $img_array;
        }
        return false;
    }

    public function paginatedPicId($picNamePath)
    {
        $picName = substr(implode("", $picNamePath), 11);
        return $this->_db->get('pictures', ['picture_name', '=', $picName])->first()->picture_id;
    }

    public function deletePicture($imageId)
    {
        return $this->_db->delete('pictures', ['picture_id', '=', $imageId]);
    }
}
?>