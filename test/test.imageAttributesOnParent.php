<?php

$Text = <<<S

Lorem ipsum dolor sit amet.

Lorem ipsum dolor sit amet.

![Block 1](https://via.placeholder.com/125x125)

Not an image caption.

![Block 2](https://via.placeholder.com/125x125)

 Image caption.

![Block 3](https://via.placeholder.com/125x125)

 Image _caption_ goes here.

    ![Block 4](https://via.placeholder.com/125x125)

     Image _caption_ goes here.

![Block 5](https://via.placeholder.com/125x125) {.center}

 Image caption.

Lorem ipsum dolor sit amet.

![Inline 1](https://via.placeholder.com/125x125) ipsum dolor sit amet.

Lorem ![Inline 2](https://via.placeholder.com/125x125) dolor sit amet.

Lorem ipsum dolor sit ![Inline 3](https://via.placeholder.com/125x125)

Lorem ipsum dolor sit amet.

![Block 6](https://via.placeholder.com/125x125)

 Image caption #1.
 Image caption #2.

 Image caption #3.

![Block 7](https://via.placeholder.com/125x125)  
 Image caption.

Lorem ipsum dolor sit amet.

S;

$Parsedown->figuresEnabled = true;
$Parsedown->figureAttributes = array('class' => 'image');
$Parsedown->imageAttributesOnParent = array('class', 'id');

echo <<<S
<style scoped>
figure {
  background: whitesmoke;
  border: 1px dashed;
  margin-right: 0;
  margin-left: 0;
  padding: 1em;
}
figcaption {
  margin: 1em 0 0;
  padding: 0;
}
figcaption p {
  border: 1px dashed;
}
figcaption p:last-child {
  margin-bottom: 0;
}
</style>
S;
