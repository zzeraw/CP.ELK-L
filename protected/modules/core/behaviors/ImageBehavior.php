<?php
class ImageBehavior extends CActiveRecordBehavior
{
    public $image_path = 'uploads';
    public $image_field = 'image';

    // Ресайзим ли оригинальное изображение?
    public $original_resize = false;
    public $original_resize_width = false;
    public $original_resize_height = false;

    // Кропим ли оригинальное изображение?
    public $original_crop = false;
    public $original_crop_width = false;
    public $original_crop_height = false;

    // Создаем ли иконку изображения?
    public $thumb = false;
    public $thumb_width = false;
    public $thumb_height = false;

    public $original_image_filename = '';

    public function getImageUrl()
    {
        return $this->_getBaseImagePath() . $this->owner->{$this->image_field};
    }

    public function getImageThumbUrl()
    {
        return $this->_getBaseImagePath() . 'thumb_' . $this->owner->{$this->image_field};
    }

    private function _getBaseImagePath()
    {
        return Yii::app()->request->baseUrl . '/' . $this->image_path . '/';
    }

    public function beforeSave($event)
    {
        // $this->owner->image = 'TRUE';

        if ($image_file = CUploadedFile::getInstance($this->owner, $this->image_field)) {
            // Получаем расширение файла
            $extension = $image_file->getExtensionName();

            // Определяем пути для нового файла
            $filename = $this->original_image_filename . '.' . $extension;
            $filename_with_path = $this->image_path . '/' . $filename;

            // Сохраняем новый файл
            if ($image_file->saveAs($filename_with_path)) {

                $image = Yii::app()->image->load($filename_with_path);

                if ($this->original_resize) {
                    $image->resize($this->original_resize_width, $this->original_resize_height);
                }

                if ($this->original_crop) {
                    $image->crop($this->original_crop_width, $this->original_crop_height);
                }

                $image->save($filename_with_path);

                if ($this->thumb) {
                    $thumb_with_path = $this->image_path . '/thumb_' . $filename;
                    $image->resize($this->thumb_width, $this->thumb_height);
                    $image->save($thumb_with_path);
                }
                $this->owner->image = $filename;
            }
        }
    }
}
?>