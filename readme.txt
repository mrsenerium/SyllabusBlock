This Block was written for Moodle 3.1+
It is a simple block that allows a Instructors to upload a Syllabus and Students may Download it.
The block is not visible to students before anything is uploaded.  Upload a file may be done using the Link provided in the block or in Edit Mode.

Added lines to
/lib/filelib.php 

ob_clean();   // discard any data in the output buffer (if possible)
flush();      // flush headers (if possible)

After the beginning of the
Function readfile_allow_large($path, $filesize)
{

}
