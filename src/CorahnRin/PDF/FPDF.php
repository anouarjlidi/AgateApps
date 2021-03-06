<?php

/**
 * This file is part of the corahn_rin package.
 *
 * (c) Alexandre Rock Ancelet <alex@orbitale.io>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace CorahnRin\PDF;

/*******************************************************************************
* FPDF                                                                         *
*                                                                              *
* Version: 1.7                                                                 *
* Date:    2011-06-18                                                          *
* Author:  Olivier PLATHEY                                                     *
*******************************************************************************/

/**
 * tFPDF (based on FPDF 1.7).
 *
 * @version        1.24
 *
 * @author         Ian Back <ianb@bpm1.com>
 * @license        GPL
 */
class FPDF
{
    protected $unifontSubset;
    protected $page; // current page number
    protected $n; // current object number
    protected $offsets; // array of object offsets
    protected $buffer; // buffer holding in-memory PDF
    protected $pages; // array containing pages
    protected $state; // current document state
    protected $compress; // compression flag
    protected $k; // scale factor (number of points in user unit)
    protected $DefOrientation; // default orientation
    protected $CurOrientation; // current orientation
    protected $StdPageSizes; // standard page sizes
    protected $DefPageSize; // default page size
    protected $CurPageSize; // current page size
    protected $PageSizes; // used for pages with non default sizes or orientations
    protected $wPt;
    protected $hPt; // dimensions of current page in points
    protected $w;
    protected $h; // dimensions of current page in user unit
    protected $lMargin; // left margin
    protected $tMargin; // top margin
    protected $rMargin; // right margin
    protected $bMargin; // page break margin
    protected $cMargin; // cell margin
    protected $x;
    protected $y; // current position in user unit
    protected $lasth; // height of last printed cell
    protected $LineWidth; // line width in user unit
    protected $fontpath; // path containing fonts
    protected $CoreFonts; // array of core font names
    protected $fonts; // array of used fonts
    protected $FontFiles; // array of font files
    protected $diffs; // array of encoding differences
    protected $FontFamily; // current font family
    protected $FontStyle; // current font style
    protected $underline; // underlining flag
    protected $CurrentFont; // current font info
    protected $FontSizePt; // current font size in points
    protected $FontSize; // current font size in user unit
    protected $DrawColor; // commands for drawing color
    protected $FillColor; // commands for filling color
    protected $TextColor; // commands for text color
    protected $ColorFlag; // indicates whether fill and text colors are different
    protected $ws; // word spacing
    protected $images; // array of used images
    protected $PageLinks; // array of links in pages
    protected $links; // array of internal links
    protected $AutoPageBreak; // automatic page breaking
    protected $PageBreakTrigger; // threshold used to trigger page breaks
    protected $InHeader; // flag set when processing header
    protected $InFooter; // flag set when processing footer
    protected $ZoomMode; // zoom display mode
    protected $LayoutMode; // layout display mode
    protected $title; // title
    protected $subject; // subject
    protected $author; // author
    protected $keywords; // keywords
    protected $creator; // creator
    protected $AliasNbPages; // alias for total number of pages
    protected $PDFVersion; // PDF version number

    /*******************************************************************************
     *                                                                              *
     *                               Public methods                                 *
     *                                                                              *
     *******************************************************************************/
    public function __construct($orientation = 'P', $unit = 'mm', $size = 'A4')
    {
        // Some checks
        $this->_dochecks();
        // Initialization of properties
        $this->page = 0;
        $this->n = 2;
        $this->buffer = '';
        $this->pages = [];
        $this->PageSizes = [];
        $this->state = 0;
        $this->fonts = [];
        $this->FontFiles = [];
        $this->diffs = [];
        $this->images = [];
        $this->links = [];
        $this->InHeader = false;
        $this->InFooter = false;
        $this->lasth = 0;
        $this->FontFamily = '';
        $this->FontStyle = '';
        $this->FontSizePt = 12;
        $this->underline = false;
        $this->DrawColor = '0 G';
        $this->FillColor = '0 g';
        $this->TextColor = '0 g';
        $this->ColorFlag = false;
        $this->ws = 0;
        // Font path
        if (\is_dir($this->fontpath)) {
//            $this->fontpath = $this->fontpath;
        } elseif (\is_dir(__DIR__.'/font')) {
            $this->fontpath = __DIR__.'/font/';
        } else {
            $this->fontpath = '';
        }
        // Core fonts
        $this->CoreFonts = ['courier', 'helvetica', 'times', 'symbol', 'zapfdingbats'];
        // Scale factor
        if ('pt' == $unit) {
            $this->k = 1;
        } elseif ('mm' == $unit) {
            $this->k = 72 / 25.4;
        } elseif ('cm' == $unit) {
            $this->k = 72 / 2.54;
        } elseif ('in' == $unit) {
            $this->k = 72;
        } else {
            $this->Error('Incorrect unit: '.$unit);
        }
        // Page sizes
        $this->StdPageSizes = [
            'a3' => [841.89, 1190.55],
            'a4' => [595.28, 841.89],
            'a5' => [420.94, 595.28],
            'letter' => [612, 792],
            'legal' => [612, 1008],
        ];
        $size = $this->_getpagesize($size);
        $this->DefPageSize = $size;
        $this->CurPageSize = $size;
        // Page orientation
        $orientation = \mb_strtolower($orientation);
        if ('p' == $orientation || 'portrait' == $orientation) {
            $this->DefOrientation = 'P';
            $this->w = $size[0];
            $this->h = $size[1];
        } elseif ('l' == $orientation || 'landscape' == $orientation) {
            $this->DefOrientation = 'L';
            $this->w = $size[1];
            $this->h = $size[0];
        } else {
            $this->Error('Incorrect orientation: '.$orientation);
        }
        $this->CurOrientation = $this->DefOrientation;
        $this->wPt = $this->w * $this->k;
        $this->hPt = $this->h * $this->k;
        // Page margins (1 cm)
        $margin = 28.35 / $this->k;
        $this->SetMargins($margin, $margin);
        // Interior cell margin (1 mm)
        $this->cMargin = $margin / 10;
        // Line width (0.2 mm)
        $this->LineWidth = .567 / $this->k;
        // Automatic page break
        $this->SetAutoPageBreak(true, 2 * $margin);
        // Default display mode
        $this->SetDisplayMode('default');
        // Enable compression
        $this->SetCompression(true);
        // Set default PDF version number
        $this->PDFVersion = '1.3';
    }

    public function SetMargins($left, $top, $right = null)
    {
        // Set left, top and right margins
        $this->lMargin = $left;
        $this->tMargin = $top;
        if (null === $right) {
            $right = $left;
        }
        $this->rMargin = $right;
    }

    public function SetLeftMargin($margin)
    {
        // Set left margin
        $this->lMargin = $margin;
        if ($this->page > 0 && $this->x < $margin) {
            $this->x = $margin;
        }
    }

    public function SetTopMargin($margin)
    {
        // Set top margin
        $this->tMargin = $margin;
    }

    public function SetRightMargin($margin)
    {
        // Set right margin
        $this->rMargin = $margin;
    }

    public function SetAutoPageBreak($auto, $margin = 0)
    {
        // Set auto page break mode and triggering margin
        $this->AutoPageBreak = $auto;
        $this->bMargin = $margin;
        $this->PageBreakTrigger = $this->h - $margin;
    }

    public function SetDisplayMode($zoom, $layout = 'default')
    {
        // Set display mode in viewer
        if ('fullpage' == $zoom || 'fullwidth' == $zoom || 'real' == $zoom || 'default' == $zoom || !\is_string($zoom)) {
            $this->ZoomMode = $zoom;
        } else {
            $this->Error('Incorrect zoom display mode: '.$zoom);
        }
        if ('single' == $layout || 'continuous' == $layout || 'two' == $layout || 'default' == $layout) {
            $this->LayoutMode = $layout;
        } else {
            $this->Error('Incorrect layout display mode: '.$layout);
        }
    }

    public function SetCompression($compress)
    {
        // Set page compression
        if (\function_exists('gzcompress')) {
            $this->compress = $compress;
        } else {
            $this->compress = false;
        }
    }

    public function SetTitle($title, $isUTF8 = false)
    {
        // Title of document
        if ($isUTF8) {
            $title = $this->_UTF8toUTF16($title);
        }
        $this->title = $title;
    }

    public function SetSubject($subject, $isUTF8 = false)
    {
        // Subject of document
        if ($isUTF8) {
            $subject = $this->_UTF8toUTF16($subject);
        }
        $this->subject = $subject;
    }

    public function SetAuthor($author, $isUTF8 = false)
    {
        // Author of document
        if ($isUTF8) {
            $author = $this->_UTF8toUTF16($author);
        }
        $this->author = $author;
    }

    public function SetKeywords($keywords, $isUTF8 = false)
    {
        // Keywords of document
        if ($isUTF8) {
            $keywords = $this->_UTF8toUTF16($keywords);
        }
        $this->keywords = $keywords;
    }

    public function SetCreator($creator, $isUTF8 = false)
    {
        // Creator of document
        if ($isUTF8) {
            $creator = $this->_UTF8toUTF16($creator);
        }
        $this->creator = $creator;
    }

    public function AliasNbPages($alias = '{nb}')
    {
        // Define an alias for total number of pages
        $this->AliasNbPages = $alias;
    }

    public function Error($msg)
    {
        // Fatal error
        throw new \RuntimeException('<b>FPDF error:</b> '.$msg);
    }

    public function Open()
    {
        // Begin document
        $this->state = 1;
    }

    public function Close()
    {
        // Terminate document
        if (3 == $this->state) {
            return;
        }
        if (0 == $this->page) {
            $this->AddPage();
        }
        // Page footer
        $this->InFooter = true;
        $this->Footer();
        $this->InFooter = false;
        // Close page
        $this->_endpage();
        // Close document
        $this->_enddoc();
    }

    public function AddPage($orientation = '', $size = '')
    {
        // Start a new page
        if (0 == $this->state) {
            $this->Open();
        }
        $family = $this->FontFamily;
        $style = $this->FontStyle.($this->underline ? 'U' : '');
        $fontsize = $this->FontSizePt;
        $lw = $this->LineWidth;
        $dc = $this->DrawColor;
        $fc = $this->FillColor;
        $tc = $this->TextColor;
        $cf = $this->ColorFlag;
        if ($this->page > 0) {
            // Page footer
            $this->InFooter = true;
            $this->Footer();
            $this->InFooter = false;
            // Close page
            $this->_endpage();
        }
        // Start new page
        $this->_beginpage($orientation, $size);
        // Set line cap style to square
        $this->_out('2 J');
        // Set line width
        $this->LineWidth = $lw;
        $this->_out(\sprintf('%.2F w', $lw * $this->k));
        // Set font
        if ($family) {
            $this->SetFont($family, $style, $fontsize);
        }
        // Set colors
        $this->DrawColor = $dc;
        if ('0 G' != $dc) {
            $this->_out($dc);
        }
        $this->FillColor = $fc;
        if ('0 g' != $fc) {
            $this->_out($fc);
        }
        $this->TextColor = $tc;
        $this->ColorFlag = $cf;
        // Page header
        $this->InHeader = true;
        $this->Header();
        $this->InHeader = false;
        // Restore line width
        if ($this->LineWidth != $lw) {
            $this->LineWidth = $lw;
            $this->_out(\sprintf('%.2F w', $lw * $this->k));
        }
        // Restore font
        if ($family) {
            $this->SetFont($family, $style, $fontsize);
        }
        // Restore colors
        if ($this->DrawColor != $dc) {
            $this->DrawColor = $dc;
            $this->_out($dc);
        }
        if ($this->FillColor != $fc) {
            $this->FillColor = $fc;
            $this->_out($fc);
        }
        $this->TextColor = $tc;
        $this->ColorFlag = $cf;
    }

    public function Header()
    {
        // To be implemented in your own inherited class
    }

    public function Footer()
    {
        // To be implemented in your own inherited class
    }

    public function PageNo()
    {
        // Get current page number
        return $this->page;
    }

    public function SetDrawColor($r, $g = null, $b = null)
    {
        // Set color for all stroking operations
        if ((0 == $r && 0 == $g && 0 == $b) || null === $g) {
            $this->DrawColor = \sprintf('%.3F G', $r / 255);
        } else {
            $this->DrawColor = \sprintf('%.3F %.3F %.3F RG', $r / 255, $g / 255, $b / 255);
        }
        if ($this->page > 0) {
            $this->_out($this->DrawColor);
        }
    }

    public function SetFillColor($r, $g = null, $b = null)
    {
        // Set color for all filling operations
        if ((0 == $r && 0 == $g && 0 == $b) || null === $g) {
            $this->FillColor = \sprintf('%.3F g', $r / 255);
        } else {
            $this->FillColor = \sprintf('%.3F %.3F %.3F rg', $r / 255, $g / 255, $b / 255);
        }
        $this->ColorFlag = ($this->FillColor != $this->TextColor);
        if ($this->page > 0) {
            $this->_out($this->FillColor);
        }
    }

    public function SetTextColor($r, $g = null, $b = null)
    {
        // Set color for text
        if ((0 == $r && 0 == $g && 0 == $b) || null === $g) {
            $this->TextColor = \sprintf('%.3F g', $r / 255);
        } else {
            $this->TextColor = \sprintf('%.3F %.3F %.3F rg', $r / 255, $g / 255, $b / 255);
        }
        $this->ColorFlag = ($this->FillColor != $this->TextColor);
    }

    public function GetStringWidth($s)
    {
        // Get width of a string in the current font
        $s = (string) $s;
        $w = 0;
        if ($this->unifontSubset) {
            $unicode = $this->UTF8StringToArray($s);
            foreach ($unicode as $char) {
                if (isset($this->CurrentFont['cw'][$char])) {
                    $w += (\ord($this->CurrentFont['cw'][2 * $char]) << 8) + \ord($this->CurrentFont['cw'][2 * $char + 1]);
                } else {
                    if ($char > 0 && $char < 128 && isset($this->CurrentFont['cw'][\chr($char)])) {
                        $w += $this->CurrentFont['cw'][\chr($char)];
                    } else {
                        if (isset($this->CurrentFont['desc']['MissingWidth'])) {
                            $w += $this->CurrentFont['desc']['MissingWidth'];
                        } else {
                            if (isset($this->CurrentFont['MissingWidth'])) {
                                $w += $this->CurrentFont['MissingWidth'];
                            } else {
                                $w += 500;
                            }
                        }
                    }
                }
            }
        } else {
            $l = \mb_strlen($s);
            for ($i = 0; $i < $l; $i++) {
                $w += $this->CurrentFont['cw'][$s[$i]];
            }
        }

        return $w * $this->FontSize / 1000;
    }

    public function SetLineWidth($width)
    {
        // Set line width
        $this->LineWidth = $width;
        if ($this->page > 0) {
            $this->_out(\sprintf('%.2F w', $width * $this->k));
        }
    }

    public function Line($x1, $y1, $x2, $y2)
    {
        // Draw a line
        $this->_out(\sprintf('%.2F %.2F m %.2F %.2F l S', $x1 * $this->k, ($this->h - $y1) * $this->k, $x2 * $this->k, ($this->h - $y2) * $this->k));
    }

    public function Rect($x, $y, $w, $h, $style = '')
    {
        // Draw a rectangle
        if ('F' == $style) {
            $op = 'f';
        } elseif ('FD' == $style || 'DF' == $style) {
            $op = 'B';
        } else {
            $op = 'S';
        }
        $this->_out(\sprintf('%.2F %.2F %.2F %.2F re %s', $x * $this->k, ($this->h - $y) * $this->k, $w * $this->k, -$h * $this->k, $op));
    }

    public function AddFont($family, $style = '', $file = '', $uni = false)
    {
        // Add a TrueType, OpenType or Type1 font
        $family = \mb_strtolower($family);
        $style = \mb_strtoupper($style);
        if ('IB' == $style) {
            $style = 'BI';
        }
        if ('' == $file) {
            if ($uni) {
                $file = \str_replace(' ', '', $family).\mb_strtolower($style).'.ttf';
            } else {
                $file = \str_replace(' ', '', $family).\mb_strtolower($style).'.php';
            }
        }
        $fontkey = $family.$style;
        if (isset($this->fonts[$fontkey])) {
            return;
        }

        if ($uni) {
            if (\file_exists($file)) {
                $ttffilename = $file;
            } else {
                $ttffilename = '';
            }
//            elseif (file_exists($this->_getfontpath().'../unifont/'.$file)) {
//                $ttffilename = $this->_getfontpath().'../unifont/'.$file ;
//            } elseif (file_exists(__DIR__.'../../PagesBundle/Resources/public/fonts/'.$file)) {
//                $ttffilename = __DIR__.'../../PagesBundle/Resources/public/fonts/'.$file;
//            } else {
//                exit('Error');
//                trigger_error('TTF file not found : '.$file, E_USER_ERROR);
//            }
            $unifilename = $this->_getfontpath().'../unifont/'.\mb_strtolower(\mb_substr($file, 0, (\mb_strpos($file, '.'))));
            $name = '';
            $originalsize = 0;
            $ttfstat = \stat($ttffilename);
            if (\file_exists($unifilename.'.mtx.php')) {
                include $unifilename.'.mtx.php';
            }
            if (!isset($type) || !isset($name) || $originalsize != $ttfstat['size']) {
                $ttffile = $ttffilename;
                //require_once($this->_getfontpath().'unifont/ttfonts.php');
                $ttf = new TTFontFile();
                $ttf->getMetrics($ttffile);
                $cw = $ttf->charWidths;
                $name = \preg_replace('/[ ()]/', '', $ttf->fullName);

                $desc = [
                    'Ascent' => \round($ttf->ascent),
                    'Descent' => \round($ttf->descent),
                    'CapHeight' => \round($ttf->capHeight),
                    'Flags' => $ttf->flags,
                    'FontBBox' => '['.\round($ttf->bbox[0]).' '.\round($ttf->bbox[1]).' '.\round($ttf->bbox[2]).' '.\round($ttf->bbox[3]).']',
                    'ItalicAngle' => $ttf->italicAngle,
                    'StemV' => \round($ttf->stemV),
                    'MissingWidth' => \round($ttf->defaultWidth),
                ];
                $up = \round($ttf->underlinePosition);
                $ut = \round($ttf->underlineThickness);
                $originalsize = $ttfstat['size'] + 0;
                $type = 'TTF';
                // Generate metrics .php file
                $s = '<?php'."\n";
                $s .= '$name=\''.$name."';\n";
                $s .= '$type=\''.$type."';\n";
                $s .= '$desc='.\var_export($desc, true).";\n";
                $s .= '$up='.$up.";\n";
                $s .= '$ut='.$ut.";\n";
                $s .= '$ttffile=\''.$ttffile."';\n";
                $s .= '$originalsize='.$originalsize.";\n";
                $s .= '$fontkey=\''.$fontkey."';\n";
                $s .= '?>';
                if (\is_writable(\dirname($this->_getfontpath().'unifont/'.'x'))) {
                    $fh = \fopen($unifilename.'.mtx.php', 'w');
                    \fwrite($fh, $s, \mb_strlen($s));
                    \fclose($fh);
                    $fh = \fopen($unifilename.'.cw.dat', 'wb');
                    \fwrite($fh, $cw, \mb_strlen($cw));
                    \fclose($fh);
                    @\unlink($unifilename.'.cw127.php');
                }
                unset($ttf);
            } else {
                $cw = @\file_get_contents($unifilename.'.cw.dat');
            }
            $i = \count($this->fonts) + 1;
            if (!empty($this->AliasNbPages)) {
                $sbarr = \range(0, 57);
            } else {
                $sbarr = \range(0, 32);
            }
            $this->fonts[$fontkey] = [
                'i' => $i,
                'type' => $type,
                'name' => $name,
                'desc' => $desc ?? null,
                'up' => $up ?? null,
                'ut' => $ut ?? null,
                'cw' => $cw,
                'ttffile' => $ttffile ?? null,
                'fontkey' => $fontkey,
                'subset' => $sbarr,
                'unifilename' => $unifilename,
            ];

            $this->FontFiles[$fontkey] = ['length1' => $originalsize, 'type' => 'TTF', 'ttffile' => $ttffile ?? null];
            $this->FontFiles[$file] = ['type' => 'TTF'];
            unset($cw);
        } else {
            $info = $this->_loadfont($file);
            $info['i'] = \count($this->fonts) + 1;
            if (!empty($info['diff'])) {
                // Search existing encodings
                $n = \array_search($info['diff'], $this->diffs, true);
                if (!$n) {
                    $n = \count($this->diffs) + 1;
                    $this->diffs[$n] = $info['diff'];
                }
                $info['diffn'] = $n;
            }
            if (!empty($info['file'])) {
                // Embedded font
                if ('TrueType' == $info['type']) {
                    $this->FontFiles[$info['file']] = ['length1' => $info['originalsize']];
                } else {
                    $this->FontFiles[$info['file']] = ['length1' => $info['size1'], 'length2' => $info['size2']];
                }
            }
            $this->fonts[$fontkey] = $info;
        }
    }

    public function SetFont($family, $style = '', $size = 0)
    {
        // Select a font; size given in points
        if ('' == $family) {
            $family = $this->FontFamily;
        } else {
            $family = \mb_strtolower($family);
        }
        $style = \mb_strtoupper($style);
        if (false !== \mb_strpos($style, 'U')) {
            $this->underline = true;
            $style = \str_replace('U', '', $style);
        } else {
            $this->underline = false;
        }
        if ('IB' == $style) {
            $style = 'BI';
        }
        if (0 == $size) {
            $size = $this->FontSizePt;
        }
        // Test if font is already selected
        if ($this->FontFamily == $family && $this->FontStyle == $style && $this->FontSizePt == $size) {
            return;
        }
        // Test if font is already loaded
        $fontkey = $family.$style;
        if (!isset($this->fonts[$fontkey])) {
            // Test if one of the core fonts
            if ('arial' == $family) {
                $family = 'helvetica';
            }
            if (\in_array($family, $this->CoreFonts, true)) {
                if ('symbol' == $family || 'zapfdingbats' == $family) {
                    $style = '';
                }
                $fontkey = $family.$style;
                if (!isset($this->fonts[$fontkey])) {
                    $this->AddFont($family, $style);
                }
            } else {
                $this->Error('Undefined font: '.$family.' '.$style);
            }
        }
        // Select it
        $this->FontFamily = $family;
        $this->FontStyle = $style;
        $this->FontSizePt = $size;
        $this->FontSize = $size / $this->k;
        $this->CurrentFont = &$this->fonts[$fontkey];
        if ('TTF' == $this->fonts[$fontkey]['type']) {
            $this->unifontSubset = true;
        } else {
            $this->unifontSubset = false;
        }
        if ($this->page > 0) {
            $this->_out(\sprintf('BT /F%d %.2F Tf ET', $this->CurrentFont['i'], $this->FontSizePt));
        }
    }

    public function SetFontSize($size)
    {
        // Set font size in points
        if ($this->FontSizePt == $size) {
            return;
        }
        $this->FontSizePt = $size;
        $this->FontSize = $size / $this->k;
        if ($this->page > 0) {
            $this->_out(\sprintf('BT /F%d %.2F Tf ET', $this->CurrentFont['i'], $this->FontSizePt));
        }
    }

    public function AddLink()
    {
        // Create a new internal link
        $n = \count($this->links) + 1;
        $this->links[$n] = [0, 0];

        return $n;
    }

    public function SetLink($link, $y = 0, $page = -1)
    {
        // Set destination of internal link
        if (-1 == $y) {
            $y = $this->y;
        }
        if (-1 == $page) {
            $page = $this->page;
        }
        $this->links[$link] = [$page, $y];
    }

    public function Link($x, $y, $w, $h, $link)
    {
        // Put a link on the page
        $this->PageLinks[$this->page][] = [
            $x * $this->k,
            $this->hPt - $y * $this->k,
            $w * $this->k,
            $h * $this->k,
            $link,
        ];
    }

    public function Text($x, $y, $txt)
    {
        // Output a string
        if ($this->unifontSubset) {
            $txt2 = '('.$this->_escape($this->UTF8ToUTF16BE($txt, false)).')';
            foreach ($this->UTF8StringToArray($txt) as $uni) {
                $this->CurrentFont['subset'][$uni] = $uni;
            }
        } else {
            $txt2 = '('.$this->_escape($txt).')';
        }
        $s = \sprintf('BT %.2F %.2F Td %s Tj ET', $x * $this->k, ($this->h - $y) * $this->k, $txt2);
        if ($this->underline && '' != $txt) {
            $s .= ' '.$this->_dounderline($x, $y, $txt);
        }
        if ($this->ColorFlag) {
            $s = 'q '.$this->TextColor.' '.$s.' Q';
        }
        $this->_out($s);
    }

    public function AcceptPageBreak()
    {
        // Accept automatic page break or not
        return $this->AutoPageBreak;
    }

    public function Cell($w, $h = 0, $txt = '', $border = 0, $ln = 0, $align = '', $fill = false, $link = '')
    {
        // Output a cell
        $k = $this->k;
        if ($this->y + $h > $this->PageBreakTrigger && !$this->InHeader && !$this->InFooter && $this->AcceptPageBreak()) {
            // Automatic page break
            $x = $this->x;
            $ws = $this->ws;
            if ($ws > 0) {
                $this->ws = 0;
                $this->_out('0 Tw');
            }
            $this->AddPage($this->CurOrientation, $this->CurPageSize);
            $this->x = $x;
            if ($ws > 0) {
                $this->ws = $ws;
                $this->_out(\sprintf('%.3F Tw', $ws * $k));
            }
        }
        if (0 == $w) {
            $w = $this->w - $this->rMargin - $this->x;
        }
        $s = '';
        if ($fill || 1 == $border) {
            if ($fill) {
                $op = (1 == $border) ? 'B' : 'f';
            } else {
                $op = 'S';
            }
            $s = \sprintf('%.2F %.2F %.2F %.2F re %s ', $this->x * $k, ($this->h - $this->y) * $k, $w * $k, -$h * $k, $op);
        }
        if (\is_string($border)) {
            $x = $this->x;
            $y = $this->y;
            if (false !== \mb_strpos($border, 'L')) {
                $s .= \sprintf('%.2F %.2F m %.2F %.2F l S ', $x * $k, ($this->h - $y) * $k, $x * $k, ($this->h - ($y + $h)) * $k);
            }
            if (false !== \mb_strpos($border, 'T')) {
                $s .= \sprintf('%.2F %.2F m %.2F %.2F l S ', $x * $k, ($this->h - $y) * $k, ($x + $w) * $k, ($this->h - $y) * $k);
            }
            if (false !== \mb_strpos($border, 'R')) {
                $s .= \sprintf('%.2F %.2F m %.2F %.2F l S ', ($x + $w) * $k, ($this->h - $y) * $k, ($x + $w) * $k, ($this->h - ($y + $h)) * $k);
            }
            if (false !== \mb_strpos($border, 'B')) {
                $s .= \sprintf('%.2F %.2F m %.2F %.2F l S ', $x * $k, ($this->h - ($y + $h)) * $k, ($x + $w) * $k, ($this->h - ($y + $h)) * $k);
            }
        }
        if ('' !== $txt) {
            if ('R' == $align) {
                $dx = $w - $this->cMargin - $this->GetStringWidth($txt);
            } elseif ('C' == $align) {
                $dx = ($w - $this->GetStringWidth($txt)) / 2;
            } else {
                $dx = $this->cMargin;
            }
            if ($this->ColorFlag) {
                $s .= 'q '.$this->TextColor.' ';
            }

            // If multibyte, Tw has no effect - do word spacing using an adjustment before each space
            if ($this->ws && $this->unifontSubset) {
                foreach ($this->UTF8StringToArray($txt) as $uni) {
                    $this->CurrentFont['subset'][$uni] = $uni;
                }
                $space = $this->_escape($this->UTF8ToUTF16BE(' ', false));
                $s .= \sprintf('BT 0 Tw %.2F %.2F Td [', ($this->x + $dx) * $k, ($this->h - ($this->y + .5 * $h + .3 * $this->FontSize)) * $k);
                $t = \explode(' ', $txt);
                $numt = \count($t);
                for ($i = 0; $i < $numt; $i++) {
                    $tx = $t[$i];
                    $tx = '('.$this->_escape($this->UTF8ToUTF16BE($tx, false)).')';
                    $s .= \sprintf('%s ', $tx);
                    if (($i + 1) < $numt) {
                        $adj = -($this->ws * $this->k) * 1000 / $this->FontSizePt;
                        $s .= \sprintf('%d(%s) ', $adj, $space);
                    }
                }
                $s .= '] TJ';
                $s .= ' ET';
            } else {
                if ($this->unifontSubset) {
                    $txt2 = '('.$this->_escape($this->UTF8ToUTF16BE($txt, false)).')';
                    foreach ($this->UTF8StringToArray($txt) as $uni) {
                        $this->CurrentFont['subset'][$uni] = $uni;
                    }
                } else {
                    $txt2 = '('.\str_replace(')', '\\)', \str_replace('(', '\\(', \str_replace('\\', '\\\\', $txt))).')';
                }
                $s .= \sprintf('BT %.2F %.2F Td %s Tj ET', ($this->x + $dx) * $k, ($this->h - ($this->y + .5 * $h + .3 * $this->FontSize)) * $k, $txt2);
            }
            if ($this->underline) {
                $s .= ' '.$this->_dounderline($this->x + $dx, $this->y + .5 * $h + .3 * $this->FontSize, $txt);
            }
            if ($this->ColorFlag) {
                $s .= ' Q';
            }
            if ($link) {
                $this->Link($this->x + $dx, $this->y + .5 * $h - .5 * $this->FontSize, $this->GetStringWidth($txt), $this->FontSize, $link);
            }
        }
        if ($s) {
            $this->_out($s);
        }
        $this->lasth = $h;
        if ($ln > 0) {
            // Go to next line
            $this->y += $h;
            if (1 == $ln) {
                $this->x = $this->lMargin;
            }
        } else {
            $this->x += $w;
        }
    }

    public function MultiCell($w, $h, $txt, $border = 0, $align = 'J', $fill = false)
    {
        // Output text with automatic or explicit line breaks
        if (0 == $w) {
            $w = $this->w - $this->rMargin - $this->x;
        }
        $wmax = ($w - 2 * $this->cMargin);
        $s = \str_replace("\r", '', $txt);
        if ($this->unifontSubset) {
            $nb = \mb_strlen($s, 'utf-8');
            while ($nb > 0 && "\n" == \mb_substr($s, $nb - 1, 1, 'utf-8')) {
                $nb--;
            }
        } else {
            $nb = \mb_strlen($s);
            if ($nb > 0 && "\n" == $s[$nb - 1]) {
                $nb--;
            }
        }
        $b = 0;
        if ($border) {
            if (1 == $border) {
                $border = 'LTRB';
                $b = 'LRT';
                $b2 = 'LR';
            } else {
                $b2 = '';
                if (false !== \mb_strpos($border, 'L')) {
                    $b2 .= 'L';
                }
                if (false !== \mb_strpos($border, 'R')) {
                    $b2 .= 'R';
                }
                $b = (false !== \mb_strpos($border, 'T')) ? $b2.'T' : $b2;
            }
        } else {
            $b2 = null;
        }
        $sep = -1;
        $i = 0;
        $j = 0;
        $l = 0;
        $ns = 0;
        $nl = 1;
        while ($i < $nb) {
            // Get next character
            if ($this->unifontSubset) {
                $c = \mb_substr($s, $i, 1, 'UTF-8');
            } else {
                $c = $s[$i];
            }
            if ("\n" == $c) {
                // Explicit line break
                if ($this->ws > 0) {
                    $this->ws = 0;
                    $this->_out('0 Tw');
                }
                if ($this->unifontSubset) {
                    $this->Cell($w, $h, \mb_substr($s, $j, $i - $j, 'UTF-8'), $b, 2, $align, $fill);
                } else {
                    $this->Cell($w, $h, \mb_substr($s, $j, $i - $j), $b, 2, $align, $fill);
                }
                $i++;
                $sep = -1;
                $j = $i;
                $l = 0;
                $ns = 0;
                $nl++;
                if ($border && 2 == $nl) {
                    $b = $b2;
                }
                continue;
            }
            if (' ' == $c) {
                $sep = $i;
                $ls = $l;
                $ns++;
            } else {
                $ls = null;
            }

            if ($this->unifontSubset) {
                $l += $this->GetStringWidth($c);
            } else {
                $l += $this->CurrentFont['cw'][$c] * $this->FontSize / 1000;
            }

            if ($l > $wmax) {
                // Automatic line break
                if (-1 == $sep) {
                    if ($i == $j) {
                        $i++;
                    }
                    if ($this->ws > 0) {
                        $this->ws = 0;
                        $this->_out('0 Tw');
                    }
                    if ($this->unifontSubset) {
                        $this->Cell($w, $h, \mb_substr($s, $j, $i - $j, 'UTF-8'), $b, 2, $align, $fill);
                    } else {
                        $this->Cell($w, $h, \mb_substr($s, $j, $i - $j), $b, 2, $align, $fill);
                    }
                } else {
                    if ('J' == $align) {
                        $this->ws = ($ns > 1) ? ($wmax - $ls) / ($ns - 1) : 0;
                        $this->_out(\sprintf('%.3F Tw', $this->ws * $this->k));
                    }
                    if ($this->unifontSubset) {
                        $this->Cell($w, $h, \mb_substr($s, $j, $sep - $j, 'UTF-8'), $b, 2, $align, $fill);
                    } else {
                        $this->Cell($w, $h, \mb_substr($s, $j, $sep - $j), $b, 2, $align, $fill);
                    }
                    $i = $sep + 1;
                }
                $sep = -1;
                $j = $i;
                $l = 0;
                $ns = 0;
                $nl++;
                if ($border && 2 == $nl) {
                    $b = $b2;
                }
            } else {
                $i++;
            }
        }
        // Last chunk
        if ($this->ws > 0) {
            $this->ws = 0;
            $this->_out('0 Tw');
        }
        if ($border && false !== \mb_strpos($border, 'B')) {
            $b .= 'B';
        }
        if ($this->unifontSubset) {
            $this->Cell($w, $h, \mb_substr($s, $j, $i - $j, 'UTF-8'), $b, 2, $align, $fill);
        } else {
            $this->Cell($w, $h, \mb_substr($s, $j, $i - $j), $b, 2, $align, $fill);
        }
        $this->x = $this->lMargin;
    }

    public function Write($h, $txt, $link = '')
    {
        // Output text in flowing mode
        $w = $this->w - $this->rMargin - $this->x;

        $wmax = ($w - 2 * $this->cMargin);
        $s = \str_replace("\r", '', $txt);
        if ($this->unifontSubset) {
            $nb = \mb_strlen($s, 'UTF-8');
            if (1 == $nb && ' ' == $s) {
                $this->x += $this->GetStringWidth($s);

                return;
            }
        } else {
            $nb = \mb_strlen($s);
        }
        $sep = -1;
        $i = 0;
        $j = 0;
        $l = 0;
        $nl = 1;
        while ($i < $nb) {
            // Get next character
            if ($this->unifontSubset) {
                $c = \mb_substr($s, $i, 1, 'UTF-8');
            } else {
                $c = $s[$i];
            }
            if ("\n" == $c) {
                // Explicit line break
                if ($this->unifontSubset) {
                    $this->Cell($w, $h, \mb_substr($s, $j, $i - $j, 'UTF-8'), 0, 2, '', 0, $link);
                } else {
                    $this->Cell($w, $h, \mb_substr($s, $j, $i - $j), 0, 2, '', 0, $link);
                }
                $i++;
                $sep = -1;
                $j = $i;
                $l = 0;
                if (1 == $nl) {
                    $this->x = $this->lMargin;
                    $w = $this->w - $this->rMargin - $this->x;
                    $wmax = ($w - 2 * $this->cMargin);
                }
                $nl++;
                continue;
            }
            if (' ' == $c) {
                $sep = $i;
            }

            if ($this->unifontSubset) {
                $l += $this->GetStringWidth($c);
            } else {
                $l += $this->CurrentFont['cw'][$c] * $this->FontSize / 1000;
            }

            if ($l > $wmax) {
                // Automatic line break
                if (-1 == $sep) {
                    if ($this->x > $this->lMargin) {
                        // Move to next line
                        $this->x = $this->lMargin;
                        $this->y += $h;
                        $w = $this->w - $this->rMargin - $this->x;
                        $wmax = ($w - 2 * $this->cMargin);
                        $i++;
                        $nl++;
                        continue;
                    }
                    if ($i == $j) {
                        $i++;
                    }
                    if ($this->unifontSubset) {
                        $this->Cell($w, $h, \mb_substr($s, $j, $i - $j, 'UTF-8'), 0, 2, '', 0, $link);
                    } else {
                        $this->Cell($w, $h, \mb_substr($s, $j, $i - $j), 0, 2, '', 0, $link);
                    }
                } else {
                    if ($this->unifontSubset) {
                        $this->Cell($w, $h, \mb_substr($s, $j, $sep - $j, 'UTF-8'), 0, 2, '', 0, $link);
                    } else {
                        $this->Cell($w, $h, \mb_substr($s, $j, $sep - $j), 0, 2, '', 0, $link);
                    }
                    $i = $sep + 1;
                }
                $sep = -1;
                $j = $i;
                $l = 0;
                if (1 == $nl) {
                    $this->x = $this->lMargin;
                    $w = $this->w - $this->rMargin - $this->x;
                    $wmax = ($w - 2 * $this->cMargin);
                }
                $nl++;
            } else {
                $i++;
            }
        }
        // Last chunk
        if ($i != $j) {
            if ($this->unifontSubset) {
                $this->Cell($l, $h, \mb_substr($s, $j, $i - $j, 'UTF-8'), 0, 0, '', 0, $link);
            } else {
                $this->Cell($l, $h, \mb_substr($s, $j), 0, 0, '', 0, $link);
            }
        }
    }

    public function Ln($h = null)
    {
        // Line feed; default value is last cell height
        $this->x = $this->lMargin;
        if (null === $h) {
            $this->y += $this->lasth;
        } else {
            $this->y += $h;
        }
    }

    public function Image($file, $x = null, $y = null, $w = 0, $h = 0, $type = '', $link = '')
    {
        // Put an image on the page
        if (!isset($this->images[$file])) {
            // First use of this image, get info
            if ('' == $type) {
                $pos = \mb_strrpos($file, '.');
                if (!$pos) {
                    $this->Error('Image file has no extension and no type was specified: '.$file);
                }
                $type = \mb_substr($file, $pos + 1);
            }
            $type = \mb_strtolower($type);
            if ('jpeg' == $type) {
                $type = 'jpg';
            }
            $mtd = '_parse'.$type;
            if (!\method_exists($this, $mtd)) {
                $this->Error('Unsupported image type: '.$type);
            }
            $info = $this->$mtd($file);
            $info['i'] = \count($this->images) + 1;
            $this->images[$file] = $info;
        } else {
            $info = $this->images[$file];
        }

        // Automatic width and height calculation if needed
        if (0 == $w && 0 == $h) {
            // Put image at 96 dpi
            $w = -96;
            $h = -96;
        }
        if ($w < 0) {
            $w = -$info['w'] * 72 / $w / $this->k;
        }
        if ($h < 0) {
            $h = -$info['h'] * 72 / $h / $this->k;
        }
        if (0 == $w) {
            $w = $h * $info['w'] / $info['h'];
        }
        if (0 == $h) {
            $h = $w * $info['h'] / $info['w'];
        }

        // Flowing mode
        if (null === $y) {
            if ($this->y + $h > $this->PageBreakTrigger && !$this->InHeader && !$this->InFooter && $this->AcceptPageBreak()) {
                // Automatic page break
                $x2 = $this->x;
                $this->AddPage($this->CurOrientation, $this->CurPageSize);
                $this->x = $x2;
            }
            $y = $this->y;
            $this->y += $h;
        }

        if (null === $x) {
            $x = $this->x;
        }
        $this->_out(\sprintf('q %.2F 0 0 %.2F %.2F %.2F cm /I%d Do Q', $w * $this->k, $h * $this->k, $x * $this->k, ($this->h - ($y + $h)) * $this->k, $info['i']));
        if ($link) {
            $this->Link($x, $y, $w, $h, $link);
        }
    }

    public function GetX()
    {
        // Get x position
        return $this->x;
    }

    public function SetX($x)
    {
        // Set x position
        if ($x >= 0) {
            $this->x = $x;
        } else {
            $this->x = $this->w + $x;
        }
    }

    public function GetY()
    {
        // Get y position
        return $this->y;
    }

    public function SetY($y)
    {
        // Set y position and reset x
        $this->x = $this->lMargin;
        if ($y >= 0) {
            $this->y = $y;
        } else {
            $this->y = $this->h + $y;
        }
    }

    public function SetXY($x, $y)
    {
        // Set x and y positions
        $this->SetY($y);
        $this->SetX($x);
    }

    public function Output($name = '', $dest = '')
    {
        // Output PDF to some destination
        if ($this->state < 3) {
            $this->Close();
        }
        $dest = \mb_strtoupper($dest);
        if ('' == $dest) {
            if ('' == $name) {
                $name = 'doc.pdf';
                $dest = 'I';
            } else {
                $dest = 'F';
            }
        }
        switch ($dest) {
            case 'I':
                // Send to standard output
                $this->_checkoutput();
                if (\PHP_SAPI != 'cli') {
                    // We send to a browser
                    \header('Content-Type: application/pdf');
                    \header('Content-Disposition: inline; filename="'.$name.'"');
                    \header('Cache-Control: private, max-age=0, must-revalidate');
                    \header('Pragma: public');
                }
                echo $this->buffer;
                break;
            case 'D':
                // Download file
                $this->_checkoutput();
                \header('Content-Type: application/x-download');
                \header('Content-Disposition: attachment; filename="'.$name.'"');
                \header('Cache-Control: private, max-age=0, must-revalidate');
                \header('Pragma: public');
                echo $this->buffer;
                break;
            case 'F':
                // Save to local file
                $f = \fopen($name, 'wb');
                if (!$f) {
                    $this->Error('Unable to create output file: '.$name);
                }
                \fwrite($f, $this->buffer, \mb_strlen($this->buffer));
                \fclose($f);
                break;
            case 'S':
                // Return as a string
                return $this->buffer;
            default:
                $this->Error('Incorrect output destination: '.$dest);
        }

        return '';
    }

    /*******************************************************************************
     *                                                                              *
     *                              Protected methods                               *
     *                                                                              *
     *******************************************************************************/
    public function _dochecks()
    {
        // Check availability of %F
        if ('1.0' != \sprintf('%.1F', 1.0)) {
            $this->Error('This version of PHP is not supported');
        }
        // Check availability of mbstring
        if (!\function_exists('mb_strlen')) {
            $this->Error('mbstring extension is not available');
        }
        // Check mbstring overloading
        if (\ini_get('mbstring.func_overload') & 2) {
            $this->Error('mbstring overloading must be disabled');
        }
        // Ensure runtime magic quotes are disabled
//        if (get_magic_quotes_runtime()) {
//            @set_magic_quotes_runtime(0);
//        }
    }

    public function _getfontpath()
    {
        return \str_replace(['/', '\\'], [\DIRECTORY_SEPARATOR, \DIRECTORY_SEPARATOR],
            \preg_replace('#\\\$#isUu', '', $this->fontpath).'/'
        );
    }

    public function _checkoutput()
    {
        if (\PHP_SAPI != 'cli') {
            if (\headers_sent($file, $line)) {
                $this->Error("Some data has already been output, can't send PDF file (output started at $file:$line)");
            }
        }
        if (\ob_get_length()) {
            // The output buffer is not empty
            if (\preg_match('/^(\xEF\xBB\xBF)?\s*$/', \ob_get_contents())) {
                // It contains only a UTF-8 BOM and/or whitespace, let's clean it
                \ob_clean();
            } else {
                $this->Error("Some data has already been output, can't send PDF file");
            }
        }
    }

    public function _getpagesize($size)
    {
        if (\is_string($size)) {
            $size = \mb_strtolower($size);
            if (!isset($this->StdPageSizes[$size])) {
                $this->Error('Unknown page size: '.$size);
            }
            $a = $this->StdPageSizes[$size];

            return [$a[0] / $this->k, $a[1] / $this->k];
        }
        if ($size[0] > $size[1]) {
            return [$size[1], $size[0]];
        }

        return $size;
    }

    public function _beginpage($orientation, $size)
    {
        $this->page++;
        $this->pages[$this->page] = '';
        $this->state = 2;
        $this->x = $this->lMargin;
        $this->y = $this->tMargin;
        $this->FontFamily = '';
        // Check page size and orientation
        if ('' == $orientation) {
            $orientation = $this->DefOrientation;
        } else {
            $orientation = \mb_strtoupper($orientation[0]);
        }
        if ('' == $size) {
            $size = $this->DefPageSize;
        } else {
            $size = $this->_getpagesize($size);
        }
        if ($orientation != $this->CurOrientation || $size[0] != $this->CurPageSize[0] || $size[1] != $this->CurPageSize[1]) {
            // New size or orientation
            if ('P' == $orientation) {
                $this->w = $size[0];
                $this->h = $size[1];
            } else {
                $this->w = $size[1];
                $this->h = $size[0];
            }
            $this->wPt = $this->w * $this->k;
            $this->hPt = $this->h * $this->k;
            $this->PageBreakTrigger = $this->h - $this->bMargin;
            $this->CurOrientation = $orientation;
            $this->CurPageSize = $size;
        }
        if ($orientation != $this->DefOrientation || $size[0] != $this->DefPageSize[0] || $size[1] != $this->DefPageSize[1]) {
            $this->PageSizes[$this->page] = [$this->wPt, $this->hPt];
        }
    }

    public function _endpage()
    {
        $this->state = 1;
    }

    public function _loadfont($font)
    {
        // Load a font definition file from the font directory
        include $this->fontpath.$font;
        $a = \get_defined_vars();
        if (!isset($a['name'])) {
            $this->Error('Could not include font definition file');
        }

        return $a;
    }

    public function _escape($s)
    {
        // Escape special characters in strings
        $s = \str_replace('\\', '\\\\', $s);
        $s = \str_replace('(', '\\(', $s);
        $s = \str_replace(')', '\\)', $s);
        $s = \str_replace("\r", '\\r', $s);

        return $s;
    }

    public function _textstring($s)
    {
        // Format a text string
        return '('.$this->_escape($s).')';
    }

    public function _UTF8toUTF16($s)
    {
        // Convert UTF-8 to UTF-16BE with BOM
        $res = "\xFE\xFF";
        $nb = \mb_strlen($s);
        $i = 0;
        while ($i < $nb) {
            $c1 = \ord($s[$i++]);
            if ($c1 >= 224) {
                // 3-byte character
                $c2 = \ord($s[$i++]);
                $c3 = \ord($s[$i++]);
                $res .= \chr((($c1 & 0x0F) << 4) + (($c2 & 0x3C) >> 2));
                $res .= \chr((($c2 & 0x03) << 6) + ($c3 & 0x3F));
            } elseif ($c1 >= 192) {
                // 2-byte character
                $c2 = \ord($s[$i++]);
                $res .= \chr(($c1 & 0x1C) >> 2);
                $res .= \chr((($c1 & 0x03) << 6) + ($c2 & 0x3F));
            } else {
                // Single-byte character
                $res .= "\0".\chr($c1);
            }
        }

        return $res;
    }

    public function _dounderline($x, $y, $txt)
    {
        // Underline text
        $up = $this->CurrentFont['up'];
        $ut = $this->CurrentFont['ut'];
        $w = $this->GetStringWidth($txt) + $this->ws * \mb_substr_count($txt, ' ');

        return \sprintf('%.2F %.2F %.2F %.2F re f', $x * $this->k, ($this->h - ($y - $up / 1000 * $this->FontSize)) * $this->k, $w * $this->k, -$ut / 1000 * $this->FontSizePt);
    }

    public function _parsejpg($file)
    {
        // Extract info from a JPEG file
        $a = \getimagesize($file);
        if (!$a) {
            $this->Error('Missing or incorrect image file: '.$file);
        }
        if (2 != $a[2]) {
            $this->Error('Not a JPEG file: '.$file);
        }
        if (!isset($a['channels']) || 3 == $a['channels']) {
            $colspace = 'DeviceRGB';
        } elseif (4 == $a['channels']) {
            $colspace = 'DeviceCMYK';
        } else {
            $colspace = 'DeviceGray';
        }
        $bpc = $a['bits'] ?? 8;
        $data = \file_get_contents($file);

        return ['w' => $a[0], 'h' => $a[1], 'cs' => $colspace, 'bpc' => $bpc, 'f' => 'DCTDecode', 'data' => $data];
    }

    public function _parsepng($file)
    {
        // Extract info from a PNG file
        $f = \fopen($file, 'rb');
        if (!$f) {
            $this->Error('Can\'t open image file: '.$file);
        }
        $info = $this->_parsepngstream($f, $file);
        \fclose($f);

        return $info;
    }

    public function _parsepngstream($f, $file)
    {
        // Check signature
        if ($this->_readstream($f, 8) != \chr(137).'PNG'.\chr(13).\chr(10).\chr(26).\chr(10)) {
            $this->Error('Not a PNG file: '.$file);
        }

        // Read header chunk
        $this->_readstream($f, 4);
        if ('IHDR' != $this->_readstream($f, 4)) {
            $this->Error('Incorrect PNG file: '.$file);
        }
        $w = $this->_readint($f);
        $h = $this->_readint($f);
        $bpc = \ord($this->_readstream($f, 1));
        if ($bpc > 8) {
            $this->Error('16-bit depth not supported: '.$file);
        }
        $ct = \ord($this->_readstream($f, 1));
        if (0 == $ct || 4 == $ct) {
            $colspace = 'DeviceGray';
        } elseif (2 == $ct || 6 == $ct) {
            $colspace = 'DeviceRGB';
        } elseif (3 == $ct) {
            $colspace = 'Indexed';
        } else {
            $this->Error('Unknown color type: '.$file);
            $colspace = null;
        }
        if (0 != \ord($this->_readstream($f, 1))) {
            $this->Error('Unknown compression method: '.$file);
        }
        if (0 != \ord($this->_readstream($f, 1))) {
            $this->Error('Unknown filter method: '.$file);
        }
        if (0 != \ord($this->_readstream($f, 1))) {
            $this->Error('Interlacing not supported: '.$file);
        }
        $this->_readstream($f, 4);
        $dp = '/Predictor 15 /Colors '.('DeviceRGB' == $colspace ? 3 : 1).' /BitsPerComponent '.$bpc.' /Columns '.$w;

        // Scan chunks looking for palette, transparency and image data
        $pal = '';
        $trns = '';
        $data = '';
        do {
            $n = $this->_readint($f);
            $type = $this->_readstream($f, 4);
            if ('PLTE' == $type) {
                // Read palette
                $pal = $this->_readstream($f, $n);
                $this->_readstream($f, 4);
            } elseif ('tRNS' == $type) {
                // Read transparency info
                $t = $this->_readstream($f, $n);
                if (0 == $ct) {
                    $trns = [\ord(\mb_substr($t, 1, 1))];
                } elseif (2 == $ct) {
                    $trns = [\ord(\mb_substr($t, 1, 1)), \ord(\mb_substr($t, 3, 1)), \ord(\mb_substr($t, 5, 1))];
                } else {
                    $pos = \mb_strpos($t, \chr(0));
                    if (false !== $pos) {
                        $trns = [$pos];
                    }
                }
                $this->_readstream($f, 4);
            } elseif ('IDAT' == $type) {
                // Read image data block
                $data .= $this->_readstream($f, $n);
                $this->_readstream($f, 4);
            } elseif ('IEND' == $type) {
                break;
            } else {
                $this->_readstream($f, $n + 4);
            }
        } while ($n);

        if ('Indexed' == $colspace && empty($pal)) {
            $this->Error('Missing palette in '.$file);
        }
        $info = [
            'w' => $w,
            'h' => $h,
            'cs' => $colspace,
            'bpc' => $bpc,
            'f' => 'FlateDecode',
            'dp' => $dp,
            'pal' => $pal,
            'trns' => $trns,
        ];
        if ($ct >= 4) {
            // Extract alpha channel
            if (!\function_exists('gzuncompress')) {
                $this->Error('Zlib not available, can\'t handle alpha channel: '.$file);
            }
            $data = \gzuncompress($data);
            $color = '';
            $alpha = '';
            if (4 == $ct) {
                // Gray image
                $len = 2 * $w;
                for ($i = 0; $i < $h; $i++) {
                    $pos = (1 + $len) * $i;
                    $color .= $data[$pos];
                    $alpha .= $data[$pos];
                    $line = \mb_substr($data, $pos + 1, $len);
                    $color .= \preg_replace('/(.)./s', '$1', $line);
                    $alpha .= \preg_replace('/.(.)/s', '$1', $line);
                }
            } else {
                // RGB image
                $len = 4 * $w;
                for ($i = 0; $i < $h; $i++) {
                    $pos = (1 + $len) * $i;
                    $color .= $data[$pos];
                    $alpha .= $data[$pos];
                    $line = \mb_substr($data, $pos + 1, $len);
                    $color .= \preg_replace('/(.{3})./s', '$1', $line);
                    $alpha .= \preg_replace('/.{3}(.)/s', '$1', $line);
                }
            }
            unset($data);
            $data = \gzcompress($color);
            $info['smask'] = \gzcompress($alpha);
            if ($this->PDFVersion < '1.4') {
                $this->PDFVersion = '1.4';
            }
        }
        $info['data'] = $data;

        return $info;
    }

    public function _readstream($f, $n)
    {
        // Read n bytes from stream
        $res = '';
        while ($n > 0 && !\feof($f)) {
            $s = \fread($f, $n);
            if (false === $s) {
                $this->Error('Error while reading stream');
            }
            $n -= \mb_strlen($s);
            $res .= $s;
        }
        if ($n > 0) {
            $this->Error('Unexpected end of stream');
        }

        return $res;
    }

    public function _readint($f)
    {
        // Read a 4-byte integer from stream
        $a = \unpack('Ni', $this->_readstream($f, 4));

        return $a['i'];
    }

    public function _parsegif($file)
    {
        // Extract info from a GIF file (via PNG conversion)
        if (!\function_exists('imagepng')) {
            $this->Error('GD extension is required for GIF support');
        }
        if (!\function_exists('imagecreatefromgif')) {
            $this->Error('GD has no GIF read support');
        }
        $im = \imagecreatefromgif($file);
        if (!$im) {
            $this->Error('Missing or incorrect image file: '.$file);
        }
        \imageinterlace($im, 0);
        $f = @\fopen('php://temp', 'rb+');
        if ($f) {
            // Perform conversion in memory
            \ob_start();
            \imagepng($im);
            $data = \ob_get_clean();
            \imagedestroy($im);
            \fwrite($f, $data);
            \rewind($f);
            $info = $this->_parsepngstream($f, $file);
            \fclose($f);
        } else {
            // Use temporary file
            $tmp = \tempnam('.', 'gif');
            if (!$tmp) {
                $this->Error('Unable to create a temporary file');
            }
            if (!\imagepng($im, $tmp)) {
                $this->Error('Error while saving to temporary file');
            }
            \imagedestroy($im);
            $info = $this->_parsepng($tmp);
            \unlink($tmp);
        }

        return $info;
    }

    public function _newobj()
    {
        // Begin a new object
        $this->n++;
        $this->offsets[$this->n] = \mb_strlen($this->buffer);
        $this->_out($this->n.' 0 obj');
    }

    public function _putstream($s)
    {
        $this->_out('stream');
        $this->_out($s);
        $this->_out('endstream');
    }

    public function _out($s)
    {
        // Add a line to the document
        if (2 == $this->state) {
            $this->pages[$this->page] .= $s."\n";
        } else {
            $this->buffer .= $s."\n";
        }
    }

    public function _putpages()
    {
        $nb = $this->page;
        if (!empty($this->AliasNbPages)) {
            // Replace number of pages in fonts using subsets
            $alias = $this->UTF8ToUTF16BE($this->AliasNbPages, false);
            $r = $this->UTF8ToUTF16BE("$nb", false);
            for ($n = 1; $n <= $nb; $n++) {
                $this->pages[$n] = \str_replace($alias, $r, $this->pages[$n]);
            }
            // Now repeat for no pages in non-subset fonts
            for ($n = 1; $n <= $nb; $n++) {
                $this->pages[$n] = \str_replace($this->AliasNbPages, $nb, $this->pages[$n]);
            }
        }
        if ('P' == $this->DefOrientation) {
            $wPt = $this->DefPageSize[0] * $this->k;
            $hPt = $this->DefPageSize[1] * $this->k;
        } else {
            $wPt = $this->DefPageSize[1] * $this->k;
            $hPt = $this->DefPageSize[0] * $this->k;
        }
        $filter = ($this->compress) ? '/Filter /FlateDecode ' : '';
        for ($n = 1; $n <= $nb; $n++) {
            // Page
            $this->_newobj();
            $this->_out('<</Type /Page');
            $this->_out('/Parent 1 0 R');
            if (isset($this->PageSizes[$n])) {
                $this->_out(\sprintf('/MediaBox [0 0 %.2F %.2F]', $this->PageSizes[$n][0], $this->PageSizes[$n][1]));
            }
            $this->_out('/Resources 2 0 R');
            if (isset($this->PageLinks[$n])) {
                // Links
                $annots = '/Annots [';
                foreach ($this->PageLinks[$n] as $pl) {
                    $rect = \sprintf('%.2F %.2F %.2F %.2F', $pl[0], $pl[1], $pl[0] + $pl[2], $pl[1] - $pl[3]);
                    $annots .= '<</Type /Annot /Subtype /Link /Rect ['.$rect.'] /Border [0 0 0] ';
                    if (\is_string($pl[4])) {
                        $annots .= '/A <</S /URI /URI '.$this->_textstring($pl[4]).'>>>>';
                    } else {
                        $l = $this->links[$pl[4]];
                        $h = isset($this->PageSizes[$l[0]]) ? $this->PageSizes[$l[0]][1] : $hPt;
                        $annots .= \sprintf('/Dest [%d 0 R /XYZ 0 %.2F null]>>', 1 + 2 * $l[0], $h - $l[1] * $this->k);
                    }
                }
                $this->_out($annots.']');
            }
            if ($this->PDFVersion > '1.3') {
                $this->_out('/Group <</Type /Group /S /Transparency /CS /DeviceRGB>>');
            }
            $this->_out('/Contents '.($this->n + 1).' 0 R>>');
            $this->_out('endobj');
            // Page content
            $p = ($this->compress) ? \gzcompress($this->pages[$n]) : $this->pages[$n];
            $this->_newobj();
            $this->_out('<<'.$filter.'/Length '.\mb_strlen($p).'>>');
            $this->_putstream($p);
            $this->_out('endobj');
        }
        // Pages root
        $this->offsets[1] = \mb_strlen($this->buffer);
        $this->_out('1 0 obj');
        $this->_out('<</Type /Pages');
        $kids = '/Kids [';
        for ($i = 0; $i < $nb; $i++) {
            $kids .= (3 + 2 * $i).' 0 R ';
        }
        $this->_out($kids.']');
        $this->_out('/Count '.$nb);
        $this->_out(\sprintf('/MediaBox [0 0 %.2F %.2F]', $wPt, $hPt));
        $this->_out('>>');
        $this->_out('endobj');
    }

    public function _putfonts()
    {
        $nf = $this->n;
        foreach ($this->diffs as $diff) {
            // Encodings
            $this->_newobj();
            $this->_out('<</Type /Encoding /BaseEncoding /WinAnsiEncoding /Differences ['.$diff.']>>');
            $this->_out('endobj');
        }
        foreach ($this->FontFiles as $file => $info) {
            if (!isset($info['type']) || 'TTF' != $info['type']) {
                // Font file embedding
                $this->_newobj();
                $this->FontFiles[$file]['n'] = $this->n;
                $font = '';
                $f = \fopen(
                //$this->_getfontpath().
                    $file, 'rb', 1);
                if (!$f) {
                    $this->Error('Font file not found');
                }
                while (!\feof($f)) {
                    $font .= \fread($f, 8192);
                }
                \fclose($f);
                $compressed = ('.z' == \mb_substr($file, -2));
                if (!$compressed && isset($info['length2'])) {
                    $header = (128 == \ord($font[0]));
                    if ($header) {
                        // Strip first binary header
                        $font = \mb_substr($font, 6);
                    }
                    if ($header && 128 == \ord($font[$info['length1']])) {
                        // Strip second binary header
                        $font = \mb_substr($font, 0, $info['length1']).\mb_substr($font, $info['length1'] + 6);
                    }
                }
                $this->_out('<</Length '.\mb_strlen($font));
                if ($compressed) {
                    $this->_out('/Filter /FlateDecode');
                }
                $this->_out('/Length1 '.$info['length1']);
                if (isset($info['length2'])) {
                    $this->_out('/Length2 '.$info['length2'].' /Length3 0');
                }
                $this->_out('>>');
                $this->_putstream($font);
                $this->_out('endobj');
            }
        }
        foreach ($this->fonts as $k => $font) {
            // Font objects
            //$this->fonts[$k]['n']=$this->n+1;
            $type = $font['type'];
            $name = $font['name'];
            if ('Core' == $type) {
                // Standard font
                $this->fonts[$k]['n'] = $this->n + 1;
                $this->_newobj();
                $this->_out('<</Type /Font');
                $this->_out('/BaseFont /'.$name);
                $this->_out('/Subtype /Type1');
                if ('Symbol' != $name && 'ZapfDingbats' != $name) {
                    $this->_out('/Encoding /WinAnsiEncoding');
                }
                $this->_out('>>');
                $this->_out('endobj');
            } elseif ('Type1' == $type || 'TrueType' == $type) {
                // Additional Type1 or TrueType font
                $this->fonts[$k]['n'] = $this->n + 1;
                $this->_newobj();
                $this->_out('<</Type /Font');
                $this->_out('/BaseFont /'.$name);
                $this->_out('/Subtype /'.$type);
                $this->_out('/FirstChar 32 /LastChar 255');
                $this->_out('/Widths '.($this->n + 1).' 0 R');
                $this->_out('/FontDescriptor '.($this->n + 2).' 0 R');
                if ($font['enc']) {
                    if (isset($font['diff'])) {
                        $this->_out('/Encoding '.($nf + $font['diff']).' 0 R');
                    } else {
                        $this->_out('/Encoding /WinAnsiEncoding');
                    }
                }
                $this->_out('>>');
                $this->_out('endobj');
                // Widths
                $this->_newobj();
                $s = '[';
                for ($i = 32; $i <= 255; $i++) {
                    $s .= $font['cw'][\chr($i)].' ';
                }
                $this->_out($s.']');
                $this->_out('endobj');
                // Descriptor
                $this->_newobj();
                $s = '<</Type /FontDescriptor /FontName /'.$name;
                foreach ($font['desc'] as $kk => $v) {
                    $s .= ' /'.$kk.' '.$v;
                }
                $file = $font['file'];
                if ($file) {
                    $s .= ' /FontFile'.('Type1' == $type ? '' : '2').' '.$this->FontFiles[$file]['n'].' 0 R';
                }
                $this->_out($s.'>>');
                $this->_out('endobj');
            } // TrueType embedded SUBSETS or FULL
            else {
                if ('TTF' == $type) {
                    $this->fonts[$k]['n'] = $this->n + 1;
                    //require_once($this->_getfontpath().'unifont/ttfonts.php');
                    $ttf = new TTFontFile();
                    $fontname = 'MPDFAA'.'+'.$font['name'];
                    $subset = $font['subset'];
                    unset($subset[0]);
                    $ttfontstream = $ttf->makeSubset($font['ttffile'], $subset);
                    $ttfontsize = \mb_strlen($ttfontstream);
                    $fontstream = \gzcompress($ttfontstream);
                    $codeToGlyph = $ttf->codeToGlyph;
                    unset($codeToGlyph[0]);

                    // Type0 Font
                    // A composite font - a font composed of other fonts, organized hierarchically
                    $this->_newobj();
                    $this->_out('<</Type /Font');
                    $this->_out('/Subtype /Type0');
                    $this->_out('/BaseFont /'.$fontname.'');
                    $this->_out('/Encoding /Identity-H');
                    $this->_out('/DescendantFonts ['.($this->n + 1).' 0 R]');
                    $this->_out('/ToUnicode '.($this->n + 2).' 0 R');
                    $this->_out('>>');
                    $this->_out('endobj');

                    // CIDFontType2
                    // A CIDFont whose glyph descriptions are based on TrueType font technology
                    $this->_newobj();
                    $this->_out('<</Type /Font');
                    $this->_out('/Subtype /CIDFontType2');
                    $this->_out('/BaseFont /'.$fontname.'');
                    $this->_out('/CIDSystemInfo '.($this->n + 2).' 0 R');
                    $this->_out('/FontDescriptor '.($this->n + 3).' 0 R');
                    if (isset($font['desc']['MissingWidth'])) {
                        $this->_out('/DW '.$font['desc']['MissingWidth'].'');
                    }

                    $this->_putTTfontwidths($font, $ttf->maxUni);

                    $this->_out('/CIDToGIDMap '.($this->n + 4).' 0 R');
                    $this->_out('>>');
                    $this->_out('endobj');

                    // ToUnicode
                    $this->_newobj();
                    $toUni = "/CIDInit /ProcSet findresource begin\n";
                    $toUni .= "12 dict begin\n";
                    $toUni .= "begincmap\n";
                    $toUni .= "/CIDSystemInfo\n";
                    $toUni .= "<</Registry (Adobe)\n";
                    $toUni .= "/Ordering (UCS)\n";
                    $toUni .= "/Supplement 0\n";
                    $toUni .= ">> def\n";
                    $toUni .= "/CMapName /Adobe-Identity-UCS def\n";
                    $toUni .= "/CMapType 2 def\n";
                    $toUni .= "1 begincodespacerange\n";
                    $toUni .= "<0000> <FFFF>\n";
                    $toUni .= "endcodespacerange\n";
                    $toUni .= "1 beginbfrange\n";
                    $toUni .= "<0000> <FFFF> <0000>\n";
                    $toUni .= "endbfrange\n";
                    $toUni .= "endcmap\n";
                    $toUni .= "CMapName currentdict /CMap defineresource pop\n";
                    $toUni .= "end\n";
                    $toUni .= 'end';
                    $this->_out('<</Length '.(\mb_strlen($toUni)).'>>');
                    $this->_putstream($toUni);
                    $this->_out('endobj');

                    // CIDSystemInfo dictionary
                    $this->_newobj();
                    $this->_out('<</Registry (Adobe)');
                    $this->_out('/Ordering (UCS)');
                    $this->_out('/Supplement 0');
                    $this->_out('>>');
                    $this->_out('endobj');

                    // Font descriptor
                    $this->_newobj();
                    $this->_out('<</Type /FontDescriptor');
                    $this->_out('/FontName /'.$fontname);
                    foreach ($font['desc'] as $kd => $v) {
                        if ('Flags' == $kd) {
                            $v = $v | 4;
                            $v = $v & ~32;
                        } // SYMBOLIC font flag
                        $this->_out(' /'.$kd.' '.$v);
                    }
                    $this->_out('/FontFile2 '.($this->n + 2).' 0 R');
                    $this->_out('>>');
                    $this->_out('endobj');

                    // Embed CIDToGIDMap
                    // A specification of the mapping from CIDs to glyph indices
                    $cidtogidmap = \str_pad('', 256 * 256 * 2, "\x00");
                    foreach ($codeToGlyph as $cc => $glyph) {
                        $cidtogidmap[$cc * 2] = \chr($glyph >> 8);
                        $cidtogidmap[$cc * 2 + 1] = \chr($glyph & 0xFF);
                    }
                    $cidtogidmap = \gzcompress($cidtogidmap);
                    $this->_newobj();
                    $this->_out('<</Length '.\mb_strlen($cidtogidmap).'');
                    $this->_out('/Filter /FlateDecode');
                    $this->_out('>>');
                    $this->_putstream($cidtogidmap);
                    $this->_out('endobj');

                    //Font file
                    $this->_newobj();
                    $this->_out('<</Length '.\mb_strlen($fontstream));
                    $this->_out('/Filter /FlateDecode');
                    $this->_out('/Length1 '.$ttfontsize);
                    $this->_out('>>');
                    $this->_putstream($fontstream);
                    $this->_out('endobj');
                    unset($ttf);
                } else {
                    // Allow for additional types
                    $this->fonts[$k]['n'] = $this->n + 1;
                    $mtd = '_put'.\mb_strtolower($type);
                    if (!\method_exists($this, $mtd)) {
                        $this->Error('Unsupported font type: '.$type);
                    }
                    $this->$mtd($font);
                }
            }
        }
    }

    public function _putTTfontwidths(&$font, $maxUni)
    {
        $rangeid = 0;
        $range = [];
        $prevcid = -2;
        $prevwidth = -1;
        $interval = false;
        $startcid = 1;
        if (\file_exists($font['unifilename'].'.cw127.php')) {
            include $font['unifilename'].'.cw127.php';
            $startcid = 128;
        }
        $cwlen = $maxUni + 1;

        // for each character
        for ($cid = $startcid; $cid < $cwlen; $cid++) {
            if (128 == $cid && (!\file_exists($font['unifilename'].'.cw127.php'))) {
                if (\is_writable(\dirname($this->_getfontpath().'../unifont/x'))) {
                    $font['unifilename'] = \str_replace('\\', '/', $font['unifilename']);
                    $font['unifilename'] = \preg_replace('#^.+/([^/]+)$#isUu', '$1', $font['unifilename']);
                    $font['unifilename'] = $this->_getfontpath().'../unifont/'.$font['unifilename'];

                    $fh = \fopen($font['unifilename'].'.cw127.php', 'wb');
                    $cw127 = '<?php'."\n";
                    $cw127 .= '$rangeid='.$rangeid.";\n";
                    $cw127 .= '$prevcid='.$prevcid.";\n";
                    $cw127 .= '$prevwidth='.$prevwidth.";\n";
                    if ($interval) {
                        $cw127 .= '$interval=true'.";\n";
                    } else {
                        $cw127 .= '$interval=false'.";\n";
                    }
                    $cw127 .= '$range='.\var_export($range, true).";\n";
                    $cw127 .= '?>';
                    \fwrite($fh, $cw127, \mb_strlen($cw127));
                    \fclose($fh);
                }
            }
            if ("\00" == $font['cw'][$cid * 2] && "\00" == $font['cw'][$cid * 2 + 1]) {
                continue;
            }
            $width = (\ord($font['cw'][$cid * 2]) << 8) + \ord($font['cw'][$cid * 2 + 1]);
            if (65535 == $width) {
                $width = 0;
            }
            if ($cid > 255 && (!isset($font['subset'][$cid]) || !$font['subset'][$cid])) {
                continue;
            }
            if (!isset($font['dw']) || (isset($font['dw']) && $width != $font['dw'])) {
                if ($cid == ($prevcid + 1)) {
                    if ($width == $prevwidth) {
                        if ($width == $range[$rangeid][0]) {
                            $range[$rangeid][] = $width;
                        } else {
                            \array_pop($range[$rangeid]);
                            // new range
                            $rangeid = $prevcid;
                            $range[$rangeid] = [];
                            $range[$rangeid][] = $prevwidth;
                            $range[$rangeid][] = $width;
                        }
                        $interval = true;
                        $range[$rangeid]['interval'] = true;
                    } else {
                        if ($interval) {
                            // new range
                            $rangeid = $cid;
                            $range[$rangeid] = [];
                            $range[$rangeid][] = $width;
                        } else {
                            $range[$rangeid][] = $width;
                        }
                        $interval = false;
                    }
                } else {
                    $rangeid = $cid;
                    $range[$rangeid] = [];
                    $range[$rangeid][] = $width;
                    $interval = false;
                }
                $prevcid = $cid;
                $prevwidth = $width;
            }
        }
        $prevk = -1;
        $nextk = -1;
        $prevint = false;
        foreach ($range as $k => $ws) {
            $cws = \count($ws);
            if (($k == $nextk) && (!$prevint) && ((!isset($ws['interval'])) || ($cws < 4))) {
                if (isset($range[$k]['interval'])) {
                    unset($range[$k]['interval']);
                }
                $range[$prevk] = \array_merge($range[$prevk], $range[$k]);
                unset($range[$k]);
            } else {
                $prevk = $k;
            }
            $nextk = $k + $cws;
            if (isset($ws['interval'])) {
                if ($cws > 3) {
                    $prevint = true;
                } else {
                    $prevint = false;
                }
                unset($range[$k]['interval']);
                --$nextk;
            } else {
                $prevint = false;
            }
        }
        $w = '';
        foreach ($range as $k => $ws) {
            if (1 == \count(\array_count_values($ws))) {
                $w .= ' '.$k.' '.($k + \count($ws) - 1).' '.$ws[0];
            } else {
                $w .= ' '.$k.' [ '.\implode(' ', $ws).' ]'."\n";
            }
        }
        $this->_out('/W ['.$w.' ]');
    }

    public function _putimages()
    {
        foreach (\array_keys($this->images) as $file) {
            $this->_putimage($this->images[$file]);
            unset($this->images[$file]['data']);
            unset($this->images[$file]['smask']);
        }
    }

    public function _putimage(&$info)
    {
        $this->_newobj();
        $info['n'] = $this->n;
        $this->_out('<</Type /XObject');
        $this->_out('/Subtype /Image');
        $this->_out('/Width '.$info['w']);
        $this->_out('/Height '.$info['h']);
        if ('Indexed' == $info['cs']) {
            $this->_out('/ColorSpace [/Indexed /DeviceRGB '.(\mb_strlen($info['pal']) / 3 - 1).' '.($this->n + 1).' 0 R]');
        } else {
            $this->_out('/ColorSpace /'.$info['cs']);
            if ('DeviceCMYK' == $info['cs']) {
                $this->_out('/Decode [1 0 1 0 1 0 1 0]');
            }
        }
        $this->_out('/BitsPerComponent '.$info['bpc']);
        if (isset($info['f'])) {
            $this->_out('/Filter /'.$info['f']);
        }
        if (isset($info['dp'])) {
            $this->_out('/DecodeParms <<'.$info['dp'].'>>');
        }
        if (isset($info['trns']) && \is_array($info['trns'])) {
            $trns = '';
            foreach ($info['trns'] as $i => $cnt) {
                $trns .= $cnt.' '.$cnt.' ';
            }
            $this->_out('/Mask ['.$trns.']');
        }
        if (isset($info['smask'])) {
            $this->_out('/SMask '.($this->n + 1).' 0 R');
        }
        $this->_out('/Length '.\mb_strlen($info['data']).'>>');
        $this->_putstream($info['data']);
        $this->_out('endobj');
        // Soft mask
        if (isset($info['smask'])) {
            $dp = '/Predictor 15 /Colors 1 /BitsPerComponent 8 /Columns '.$info['w'];
            $smask = [
                'w' => $info['w'],
                'h' => $info['h'],
                'cs' => 'DeviceGray',
                'bpc' => 8,
                'f' => $info['f'],
                'dp' => $dp,
                'data' => $info['smask'],
            ];
            $this->_putimage($smask);
        }
        // Palette
        if ('Indexed' == $info['cs']) {
            $filter = ($this->compress) ? '/Filter /FlateDecode ' : '';
            $pal = ($this->compress) ? \gzcompress($info['pal']) : $info['pal'];
            $this->_newobj();
            $this->_out('<<'.$filter.'/Length '.\mb_strlen($pal).'>>');
            $this->_putstream($pal);
            $this->_out('endobj');
        }
    }

    public function _putxobjectdict()
    {
        foreach ($this->images as $image) {
            $this->_out('/I'.$image['i'].' '.$image['n'].' 0 R');
        }
    }

    public function _putresourcedict()
    {
        $this->_out('/ProcSet [/PDF /Text /ImageB /ImageC /ImageI]');
        $this->_out('/Font <<');
        foreach ($this->fonts as $font) {
            $this->_out('/F'.$font['i'].' '.$font['n'].' 0 R');
        }
        $this->_out('>>');
        $this->_out('/XObject <<');
        $this->_putxobjectdict();
        $this->_out('>>');
    }

    public function _putresources()
    {
        $this->_putfonts();
        $this->_putimages();
        // Resource dictionary
        $this->offsets[2] = \mb_strlen($this->buffer);
        $this->_out('2 0 obj');
        $this->_out('<<');
        $this->_putresourcedict();
        $this->_out('>>');
        $this->_out('endobj');
    }

    public function _putinfo()
    {
        if (!empty($this->title)) {
            $this->_out('/Title '.$this->_textstring($this->title));
        }
        if (!empty($this->subject)) {
            $this->_out('/Subject '.$this->_textstring($this->subject));
        }
        if (!empty($this->author)) {
            $this->_out('/Author '.$this->_textstring($this->author));
        }
        if (!empty($this->keywords)) {
            $this->_out('/Keywords '.$this->_textstring($this->keywords));
        }
        if (!empty($this->creator)) {
            $this->_out('/Creator '.$this->_textstring($this->creator));
        }
        $this->_out('/CreationDate '.$this->_textstring('D:'.@\date('YmdHis')));
    }

    public function _putcatalog()
    {
        $this->_out('/Type /Catalog');
        $this->_out('/Pages 1 0 R');
        if ('fullpage' == $this->ZoomMode) {
            $this->_out('/OpenAction [3 0 R /Fit]');
        } elseif ('fullwidth' == $this->ZoomMode) {
            $this->_out('/OpenAction [3 0 R /FitH null]');
        } elseif ('real' == $this->ZoomMode) {
            $this->_out('/OpenAction [3 0 R /XYZ null null 1]');
        } elseif (!\is_string($this->ZoomMode)) {
            $this->_out('/OpenAction [3 0 R /XYZ null null '.\sprintf('%.2F', $this->ZoomMode / 100).']');
        }
        if ('single' == $this->LayoutMode) {
            $this->_out('/PageLayout /SinglePage');
        } elseif ('continuous' == $this->LayoutMode) {
            $this->_out('/PageLayout /OneColumn');
        } elseif ('two' == $this->LayoutMode) {
            $this->_out('/PageLayout /TwoColumnLeft');
        }
    }

    public function _putheader()
    {
        $this->_out('%PDF-'.$this->PDFVersion);
    }

    public function _puttrailer()
    {
        $this->_out('/Size '.($this->n + 1));
        $this->_out('/Root '.$this->n.' 0 R');
        $this->_out('/Info '.($this->n - 1).' 0 R');
    }

    public function _enddoc()
    {
        $this->_putheader();
        $this->_putpages();
        $this->_putresources();
        // Info
        $this->_newobj();
        $this->_out('<<');
        $this->_putinfo();
        $this->_out('>>');
        $this->_out('endobj');
        // Catalog
        $this->_newobj();
        $this->_out('<<');
        $this->_putcatalog();
        $this->_out('>>');
        $this->_out('endobj');
        // Cross-ref
        $o = \mb_strlen($this->buffer);
        $this->_out('xref');
        $this->_out('0 '.($this->n + 1));
        $this->_out('0000000000 65535 f ');
        for ($i = 1; $i <= $this->n; $i++) {
            $this->_out(\sprintf('%010d 00000 n ', $this->offsets[$i]));
        }
        // Trailer
        $this->_out('trailer');
        $this->_out('<<');
        $this->_puttrailer();
        $this->_out('>>');
        $this->_out('startxref');
        $this->_out($o);
        $this->_out('%%EOF');
        $this->state = 3;
    }

    // ********* NEW FUNCTIONS *********
    // Converts UTF-8 strings to UTF16-BE.
    public function UTF8ToUTF16BE($str, $setbom = true)
    {
        $outstr = '';
        if ($setbom) {
            $outstr .= "\xFE\xFF"; // Byte Order Mark (BOM)
        }
        $outstr .= \mb_convert_encoding($str, 'UTF-16BE', 'UTF-8');

        return $outstr;
    }

    // Converts UTF-8 strings to codepoints array
    public function UTF8StringToArray($str)
    {
        $out = [];
        $len = \mb_strlen($str);
        for ($i = 0; $i < $len; $i++) {
            $uni = -1;
            $h = \ord($str[$i]);
            if ($h <= 0x7F) {
                $uni = $h;
            } elseif ($h >= 0xC2) {
                if (($h <= 0xDF) && ($i < $len - 1)) {
                    $uni = ($h & 0x1F) << 6 | (\ord($str[++$i]) & 0x3F);
                } elseif (($h <= 0xEF) && ($i < $len - 2)) {
                    $uni = ($h & 0x0F) << 12 | (\ord($str[++$i]) & 0x3F) << 6
                        | (\ord($str[++$i]) & 0x3F);
                } elseif (($h <= 0xF4) && ($i < $len - 3)) {
                    $uni = ($h & 0x0F) << 18 | (\ord($str[++$i]) & 0x3F) << 12
                        | (\ord($str[++$i]) & 0x3F) << 6
                        | (\ord($str[++$i]) & 0x3F);
                }
            }
            if ($uni >= 0) {
                $out[] = $uni;
            }
        }

        return $out;
    }
}
