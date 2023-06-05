<?php
/**
	 * 画像サイズを変形して保存する
	 * @param string $srcPath 作成画像のパス
	 * @param string $dstPath 画像の作成先の配置パス
	 * @param int $need_width 作りたい横幅
	 * @param int $need_height 作りたい高さ
	 */
	public function transformImageSize($srcPath, $dstPath, $needWidth, $needHeight)
	{
		log_message('debug','transformImageSizeの画像データ');
		log_message('debug', print_r($srcPath,true));

		//画像情報(横幅、高さ、画像オブジェクト)を取得
		$temp_result = $this->getImgInfo($srcPath);
		// log_message('debug', print_r($temp_result,true));

		$original_width = $temp_result['width'];//600
		$original_height = $temp_result['height'];//600
		$source = $temp_result['source'];

		//canvasを作る
		//need_width 204
		//need_height 390
    
    
		//デフォルト--------------
		// $canvas = imagecreatetruecolor($needWidth, $needHeight);

		// imagecopyresampled($canvas, $source, 0, 0, 0, 0, $needWidth, $needHeight, $original_width, $original_height);

		// //リサイズ済みcanvasを目的のパスへ移動
		// imagejpeg($canvas, $dstPath);

		// //メモリ解放
		// imagedestroy($source);
		// imagedestroy($canvas);
		// unset($source);
		// unset($canvas);
		// unset($temp_result['source']);





		//参考 https://blog.kaburk.com/blog/archives/146

		// ---------------------------------------------------
		// 完成画像が横長画像
		if ($needWidth > $needHeight) {
			log_message('debug','1ルート');
			log_message('debug', print_r($needWidth,true));
			log_message('debug', print_r($needHeight,true));

			// 横幅をあわせて縦横比を保ったまま縮小拡大する
			$needHeight_adj_size = $original_height * ($needWidth / $original_width);
			log_message('debug', print_r($needHeight_adj_size,true));

			$canvas = imagecreatetruecolor($needWidth, $needHeight_adj_size);
			imagecopyresampled($canvas, $source, 0, 0, 0, 0, $needWidth, $needHeight_adj_size, $original_width, $original_height);

			// 左上の位置を中心から算出
			$dst_x = 0;
			$dst_y = abs(($needHeight_adj_size / 2) - ($needHeight / 2));

			log_message('debug','切り取り位置');
			log_message('debug', print_r($dst_x,true));
			log_message('debug', print_r($dst_y,true));


		// ---------------------------------------------------
		// 完成画像が縦長画像
		} else {
			log_message('debug','2ルート');
			// 縦幅をあわせて縦横比を保ったまま縮小拡大する
			$needWidth_adj_size = $original_width * ($needHeight / $original_height);
			$canvas = imagecreatetruecolor($needWidth_adj_size, $needHeight);
			imagecopyresampled($canvas, $source, 0, 0, 0, 0, $needWidth_adj_size, $needHeight, $original_width, $original_height);
			// 左上の位置を中心から算出
			$dst_x = abs(($needWidth_adj_size / 2) - ($needWidth / 2));
			$dst_y = 0;

			log_message('debug', print_r($dst_x,true));
			log_message('debug', print_r($dst_y,true));
		}

		// 指定した位置とサイズで切り抜く
		$canvas = imagecrop($canvas, ['x' => $dst_x, 'y' => $dst_y, 'width' => $needWidth, 'height' => $needHeight]);

		// ファイルへ保存
		imagejpeg($canvas, $dstPath);
		imagedestroy($source);
		imagedestroy($canvas);

	}
