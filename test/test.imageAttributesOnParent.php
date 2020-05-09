<?php

$Text = <<<S

Lorem ipsum dolor sit amet.

Lorem ipsum dolor sit amet.

![Block 1](https://via.placeholder.com/125x125)

Lorem ipsum dolor sit amet.

![Block 2](https://via.placeholder.com/125x125 "Image caption.")

 ![Block 3](https://via.placeholder.com/125x125 "Image _caption_ goes here.")

    ![Block 4](https://via.placeholder.com/125x125 "Image _caption_ goes here.")

![Block 5](https://via.placeholder.com/125x125 "Image caption.") {#image-1.center width=125 height=125}

Lorem ipsum dolor sit amet.

![Inline 1](https://via.placeholder.com/125x125) ipsum dolor sit amet.

Lorem ![Inline 2](https://via.placeholder.com/125x125) dolor sit amet.

Lorem ipsum dolor sit ![Inline 3](https://via.placeholder.com/125x125)

Lorem ipsum dolor sit amet.

S;

$Parsedown->figuresEnabled = true;
$Parsedown->figureAttributes = array('class' => 'image');
$Parsedown->imageAttributesOnParent = array('class', 'id');
