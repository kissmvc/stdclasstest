# stdclasstest
stdClass &amp; Magic methods speed test.

# results
It seems that speed of php array & stdClass is relatively same, but object created by mygic methods is 2x slower than stdClass. Surprise - extended stdClass is still 2x faster than object created by magic methods.

##Integer test (add integer to member): 

### stdObject test

Memory: 0.25 MB

Memory Peak: 0.25 MB

Time: 0.94675898551941

### stdObject2 test

Memory: 0.25 MB

Memory Peak: 0.25 MB

Time: 0.17570304870605

### stdObject3 test

Memory: 0.25 MB

Memory Peak: 0.25 MB

Time: 0.95497179031372

### stdObject4 test

Memory: 0.25 MB

Memory Peak: 0.25 MB

Time: 0.71585416793823

### stdClass test
Memory: 0.25 MB
Memory Peak: 0.25 MB
Time: 0.17567706108093

### Array test

Memory: 0.25 MB

Memory Peak: 0.25 MB

Time: 0.16199588775635


## String test (add string to member):

### stdObject test

Memory: 0.25 MB

Memory Peak: 0.25 MB

Time: 0.97530794143677

### stdObject2 test

Memory: 0.25 MB

Memory Peak: 0.25 MB

Time: 0.19725203514099

### stdObject3 test
Memory: 0.25 MB
Memory Peak: 0.25 MB
Time: 1.00172996521

### stdObject4 test

Memory: 0.25 MB

Memory Peak: 0.25 MB

Time: 0.76920986175537

### stdClass test

Memory: 0.25 MB

Memory Peak: 0.25 MB

Time: 0.19884610176086

### Array test
Memory: 0.25 MB
Memory Peak: 0.25 MB
Time: 0.14026379585266


## Array test (add array to member):

### stdObject test

Memory: 0.25 MB

Memory Peak: 0.25 MB

Time: 1.3097100257874

### stdObject2 test
Memory: 0.25 MB
Memory Peak: 0.25 MB
Time: 0.4960470199585

### stdObject3 test

Memory: 0.25 MB

Memory Peak: 0.25 MB

Time: 1.3164200782776

### stdObject4 test

Memory: 0.25 MB

Memory Peak: 0.25 MB

Time: 1.1125841140747

### stdClass test

Memory: 0.25 MB

Memory Peak: 0.25 MB

Time: 0.50473880767822

### Array test

Memory: 0.25 MB

Memory Peak: 0.25 MB

Time: 0.40760684013367


## Function call (add closure to member and call it 300000 times)

### stdObject test

Memory: 0.25 MB

Memory Peak: 0.25 MB

Time: 6.132091999054

### stdObject2 test

Memory: 0.25 MB

Memory Peak: 0.25 MB

Time: 3.448075056076

### stdObject3 test

Memory: 0.25 MB

Memory Peak: 0.25 MB

Time: 4.0565159320831

### stdObject4 test

Memory: 0.25 MB

Memory Peak: 0.25 MB

Time: 1.263090133667

### stdClass test

Memory: 0.25 MB

Memory Peak: 0.25 MB

Time: 0.17686295509338

### Array test

Memory: 0.25 MB

Memory Peak: 0.25 MB

Time: 0.36638998985291

