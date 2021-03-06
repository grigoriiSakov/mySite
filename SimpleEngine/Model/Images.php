<?php
/**
 * Created by PhpStorm.
 * User: grigorii
 * Date: 24.07.16
 * Time: 20:24
 */

namespace SimpleEngine\Model;


class Images
{

    private static $instance = null;

    private function __construct()
    {

    }

    public function instance()
    {
        if (self::$instance === null) {
            self::$instance = new Images();

        }
        return self::$instance;
    }
    public function addImage (){
        $file='';
        $result = array(
            'ok' => false,
            'error' => '',
            "file_name" => ''
        );
        foreach ($_FILES as $val){
            $file = $val;
        }
        if(!empty($file['name'])){ // если передан не пустой файл
            if($file['size']<10485760){ // не больше 10 мб
                if(explode('/',$file['type'])[0] == 'image') { // картинка
                    if (!file_exists($_SERVER['DOCUMENT_ROOT'] . "/img/" . $file['name'])) { // файла стаким именем нет в папке изображений
                       // добавляем в папку
                       if($this -> saveFile($file)){
                           $result['ok'] = true;
                           $result['file_name'] = $file['name'];


                       }
                        else{
                            $result['error'] = 'ошибка загрузки файла';
                        }
                   }
                    else{
                        $result['error'] = "файл с таким именем уже существует";
                    }
                }
                else{
                    $result['error'] = "Допусимы только изображения";
                }
            }
              else{
                  $result['error']= "Файл должен быть не более 10 Mб";
              }

        }
        else{
           $result['error'] = 'Не выбран файл';
        }
        return $result;
    }

    public function reSize ($name, $width, $height)
    {
        $path =  $_SERVER['DOCUMENT_ROOT'] . "\img\$name";
        return $this->create_thumbnail($path, false,$width,$height);
    }

    protected function create_thumbnail($path, $save, $width, $height) {
        $info = getimagesize($path); //получаем размеры картинки и ее тип
        $size = array($info[0], $info[1]); //закидываем размеры в массив

        //В зависимости от расширения картинки вызываем соответствующую функцию
        if ($info['mime'] == 'image/png') {
            $src = imagecreatefrompng($path); //создаём новое изображение из файла
        } else if ($info['mime'] == 'image/jpeg') {
            $src = imagecreatefromjpeg($path);
        } else if ($info['mime'] == 'image/gif') {
            $src = imagecreatefromgif($path);
        } else {
            return false;
        }

        $thumb = imagecreatetruecolor($width, $height); //возвращает идентификатор изображения, представляющий черное изображение заданного размера
        $src_aspect = $size[0] / $size[1]; //отношение ширины к высоте исходника
        $thumb_aspect = $width / $height; //отношение ширины к высоте аватарки

        if($src_aspect < $thumb_aspect) { 		//узкий вариант (фиксированная ширина) 		$scale = $width / $size[0]; 		$new_size = array($width, $width / $src_aspect); 		$src_pos = array(0, ($size[1] * $scale - $height) / $scale / 2); //Ищем расстояние по высоте от края картинки до начала картины после обрезки 	} else if ($src_aspect > $thumb_aspect) {
            //широкий вариант (фиксированная высота)
            $scale = $height / $size[1];
            $new_size = array($height * $src_aspect, $height);
            $src_pos = array(($size[0] * $scale - $width) / $scale / 2, 0); //Ищем расстояние по ширине от края картинки до начала картины после обрезки
        } else {
            //другое
            $new_size = array($width, $height);
            $src_pos = array(0,0);
        }

        $new_size[0] = max($new_size[0], 1);
        $new_size[1] = max($new_size[1], 1);

        imagecopyresampled($thumb, $src, 0, 0, $src_pos[0], $src_pos[1], $new_size[0], $new_size[1], $size[0], $size[1]);
        //Копирование и изменение размера изображения с ресемплированием

        if($save === false) {
            return imagepng($thumb); //Выводит JPEG/PNG/GIF изображение
        } else {
            return imagepng($thumb, $save);//Сохраняет JPEG/PNG/GIF изображение
        }
    }

    protected  function saveFile($file)
    {
        $result = false;
        if (copy($file['tmp_name'], $_SERVER['DOCUMENT_ROOT'] . '/img/' . $file['name'])) {
            $result = true;
        }
        return $result;
    }

}
