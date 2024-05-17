<?php

/**
 * CodeIgniter
 *
 * An open source application development framework for PHP
 *
 * This content is released under the MIT License (MIT)
 *
 * Copyright (c) 2014 - 2017, British Columbia Institute of Technology
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 *
 * @package	CodeIgniter
 * @author	EllisLab Dev Team
 * @copyright	Copyright (c) 2008 - 2014, EllisLab, Inc. (https://ellislab.com/)
 * @copyright	Copyright (c) 2014 - 2017, British Columbia Institute of Technology (http://bcit.ca/)
 * @license	http://opensource.org/licenses/MIT	MIT License
 * @link	https://codeigniter.com
 * @since	Version 1.0.0
 * @filesource
 */
defined('BASEPATH') or exit('No direct script access allowed');

// menganti semua validation berikut menjadi bhs jepang
$lang['form_validation_required'] = '{field} 必須フィールド。';
$lang['form_validation_isset'] = '{field} には値が必要です。';
$lang['form_validation_valid_email'] = '{field} フィールドには有効なメールアドレスが含まれている必要があります。';
$lang['form_validation_valid_emails'] = '{field} フィールドには、すべての有効な電子メール アドレスを含める必要があります。';
$lang['form_validation_valid_url'] = '{field} フィールドには有効な URL が含まれている必要があります。';
$lang['form_validation_valid_ip'] = '{field} フィールドには有効な IP が含まれている必要があります。';
$lang['form_validation_min_length'] = '{field} フィールドの長さは少なくとも {param} 文字でなければなりません。';
$lang['form_validation_max_length'] = '{field} フィールドの長さは {param} 文字を超えることはできません。';
$lang['form_validation_exact_length'] = '{field} フィールドの長さは正確に {param} 文字でなければなりません。';
$lang['form_validation_alpha'] = '{field} フィールドにはアルファベット文字のみを含めることができます。';
$lang['form_validation_alpha_numeric'] = '{field} フィールドには、英数字のみを含めることができます。';
$lang['form_validation_alpha_numeric_spaces'] = '{field} フィールドには、英数字とスペースのみを含めることができます。';
$lang['form_validation_alpha_dash'] = '{field} フィールドには、英数字、アンダースコア、およびダッシュのみを含めることができます。';
$lang['form_validation_numeric'] = '{field} フィールドには数字のみを含める必要があります。';
$lang['form_validation_is_numeric'] = '{field} フィールドには数字のみを含める必要があります。';
$lang['form_validation_integer'] = '{field} フィールドには整数が含まれている必要があります。';
$lang['form_validation_regex_match'] = '{field} フィールドの形式が正しくありません。';
$lang['form_validation_matches'] = '{field} フィールドが {param} フィールドと一致しません。';
$lang['form_validation_differs'] = '{field} フィールドは {param} フィールドと異なっている必要があります。';
$lang['form_validation_is_unique'] = '{field} フィールドには一意の値が含まれている必要があります。';
$lang['form_validation_is_natural'] = '{field} フィールドには数字のみを含める必要があります。';
$lang['form_validation_is_natural_no_zero'] = '{field} フィールドには数字のみを含め、0 より大きくする必要があります。';
$lang['form_validation_decimal'] = '{field} フィールドには 10 進数を含める必要があります。';
$lang['form_validation_less_than'] = '{field} フィールドには、{param} 未満の数値が含まれている必要があります。';
$lang['form_validation_less_than_equal_to'] = '{field} フィールドには、{param} 以下の数値が含まれている必要があります。';
$lang['form_validation_greater_than'] = '{field} フィールドには、{param} より大きい数値が含まれている必要があります。';
$lang['form_validation_greater_than_equal_to'] = '{field} フィールドには、{param} 以上の数値が含まれている必要があります。';
$lang['form_validation_error_message_not_set'] = 'フィールド名 {field} に対応するエラー メッセージにアクセスできません。';
$lang['form_validation_in_list'] = '{field} フィールドは {param} のいずれかでなければなりません。';
