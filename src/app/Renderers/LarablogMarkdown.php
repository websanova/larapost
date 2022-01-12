<?php

namespace Websanova\Larablog\Renderers;

use Exception;

class LarablogMarkdown
{
    // required (core)

    // body
    // date
    // title
    // permalink

    // optional (core)

    // keywords
    // description
    // tag/tag(s)
    // image(s)
    // redirect(s)

    // NOTE: Format:
    //       - Must contain '---' on first line.
    //       - Must contain closing '---'.
    //       - Must contain valid format between '---'.
    //       - Must contain at least date, title, permalink.
    //       - The rest is body text which can be empty.

    // NOTE: Any space/before after a line does not matter and will be
    //       trimmed. So within the opening/closing "---" any tabbing
    //       style can be used.

    public static function parse(String $contents = '')
    {
        // return in format
        // -
        // - body-raw
        // - body

        $data = [];

        $lines = preg_split("/\n|\n\r/", $contents);

        foreach ($lines as $index => $line) {
            $line = trim($line);

            if ($index === 0 && $line !== '---') {
                throw new Exception('Line ' . $index . ' - ' . $line);
            }
        }



        return $data;
    }
}