cake-help(1) -- Get help on cake script
=======================================

## SYNOPSIS

    cake help
    cake -h <topic> help
    cake --help <topic> help

## DESCRIPTION

If supplied a topic, then show the appropriate documentation page.

If the topic does not exist, then it attempts to read the documentation, parsed
from markdown content in tasks source files. If neither of the topic or tasks file
exist, then it'll show the README documentation page.

## TOPICS

The following topics are available: 

* cake -h cake help
* cake -h config help
* cake -h help help
* cake -h intro help 
* cake -h js help
* cake -h css help

The following are available as topics fallback and match one of the task in tasks/
 
* cake -h build help
* cake -h createproject help
* cake -h css help
* cake -h docs help
* cake -h help help
* cake -h html help
* cake -h img help
* cake -h js help
* cake -h test help

### viewer

The program used to view help content is man on Posix. Relatedly, one may want to view the
docs in a browser instead.

## SEE ALSO

* cake -h cake help

