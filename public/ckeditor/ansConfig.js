/**
 * Created by Xavier on 3/10/15.
 */
/**
 * @license Copyright (c) 2003-2015, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.md or http://ckeditor.com/license
 */

CKEDITOR.editorConfig = function( config ) {
    // Define changes to default configuration here. For example:
    // config.language = 'fr';
    // config.uiColor = '#AADC6E';

    config.font_names = '標楷體/Georgia, "楷體", BiauKai, DFKai-SB, "华文楷体", stkaiti, KaiTi, "楷体", SimKai, serif;' + '明體/"Times New Roman", Times, "細明體", MingLiU, "新細明體", PMingLiU, serif;' + '宋體/"Times New Roman", Times, "儷宋 Pro", "LiSong Pro", "細宋體", SimSun, "新宋體", "宋体", NSimSun, serif;' + '黑體/Arial, Helvetica, "儷黑 Pro", "LiHei Pro", "微軟正黑體", "Microsoft JhengHei", "黑體", "黑体", SimHei, sans-serif;' + config.font_names;
    config.fontSize_defaultLabel = "22px";


    config.language = 'en';
    config.keystrokes = [[ 13 /*Enter*/, 'blur']];
    //config.removePlugins = 'elementspath';
    config.resize_enabled = false;
    config.height = 60;
    config.autoParagraph = false;
    config.toolbar= [
        { name: 'inserts',   items: [  "EqnEditor", "FontSize" ] }
    ];

    config.allowedContent = true;
};
