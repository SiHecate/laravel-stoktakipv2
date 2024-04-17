<?php

namespace App\Support;

use Illuminate\Support\Facades\Storage;

class Helper
{
    /**
     * Resim yükleme fonksiyonu.
     *
     * @param \Illuminate\Http\UploadedFile|null $image Yüklenmek istenen resim dosyası.
     * @param string $folderName Resmin yüklenmek istediği klasör adı.
     * @return string|null Yüklenen resim dosyasının yolu veya hata durumunda null.
     */
    public static function uploadImage($image, $folderName)
    {
        if (!$image || $image->isEmpty()) {
            return null;
        }
        try {
            $imagePath = Storage::disk('public')->put($folderName, $image);
        } catch (\Exception $e) {
            return null;
        }
        return $imagePath;
    }

    /**
     * Resim silme fonksiyonu.
     *
     * @param string $image Silinmek istenen resim dosyasının adı.
     * @param string $folderName Resmin bulunduğu klasör adı.
     * @return void
    */
    public static function removeImage($image, $folderName) {
        if (!$image) {
            return;
        }
        Storage::disk('public')->delete($folderName . '/' . $image);
    }

    /**
     * Resim güncelleme fonksiyonu.
     *
     * @param string $image Güncellenmek istenen resim dosyasının adı.
     * @param string $folderName Resmin bulunduğu klasör adı.
     * @return string|null Güncellenen resim dosyasının yolu veya hata durumunda null
     */
    public static function updateImage($image, $folderName) {
        $currentImage = Storage::get($folderName . '/' . $image);
        if (!$currentImage) {
            return null;
        } else {
            Storage::disk('public')->delete($folderName . '/' . $image);
            Storage::disk('public')->put($folderName, $image);
        }
    }

    /**
     * Resim gösterme fonksiyonu.
     *
     * @param string $image Gösterilmek istenen resim dosyasının adı.
     * @param string $folderName Resmin bulunduğu klasör adı.
     * @return string|null Gösterilen resim dosyasının yolu veya hata durumunda null.
     */
    public static function showImage($image, $folderName) {
        if (!$image) {
            return null;
        }
        return Storage::showImage($folderName . '/' . $image);
    }
}
