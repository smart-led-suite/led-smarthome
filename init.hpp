#ifndef _init_hpp
#define _init_hpp
#include "led-blaster-pre.hpp"
#include "config.h"

#include <iostream>
#include <cstdlib>
#include <pigpio.h>
#include <stdio.h>
#include <pthread.h>
#include <stdint.h> //libary which includes uint8_t etc.

bool initGeneral(void); //initializes the libary
bool initPin(int pin, uint16_t mode); //initializes a single pin


#endif