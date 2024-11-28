// lib3.js (React)
import React, { useState } from 'react';
import { useForm } from 'react-hook-form';

const Lib3 = () => {
  const { register, handleSubmit, watch, errors } = useForm();
  const [progress, setProgress] = useState(0);

  const onSubmit = (data) => {
    alert(JSON.stringify(data, null, 2));
  };

  const watchFields = watch(["make", "model", "year", "location"]);

  // Function to calculate progress
  const calculateProgress = () => {
    let filledFields = 0;
    if (watchFields.make) filledFields++;
    if (watchFields.model) filledFields++;
    if (watchFields.year) filledFields++;
    if (watchFields.location) filledFields++;
    return (filledFields / 4) * 100;
  };

  return (
    <div>
      <h1>Lib3: Visual Form Validation with React Hook Form</h1>
      <form onSubmit={handleSubmit(onSubmit)}>
        <div>
          <label htmlFor="make">Car Make</label>
          <input name="make" ref={register({ required: true })} />
          {errors.make && <span>This field is required</span>}
        </div>

        <div>
          <label htmlFor="model">Car Model</label>
          <input name="model" ref={register({ required: true })} />
          {errors.model && <span>This field is required</span>}
        </div>

        <div>
          <label htmlFor="year">Car Year</label>
          <input name="year" type="number" ref={register({ required: true })} />
          {errors.year && <span>This field is required</span>}
        </div>

        <div>
          <label htmlFor="location">Car Location</label>
          <input name="location" ref={register({ required: true })} />
          {errors.location && <span>This field is required</span>}
        </div>

        <div style={{ marginTop: '20px' }}>
          <label>Progress</label>
          <progress value={calculateProgress()} max="100" style={{ width: '100%' }}></progress>
        </div>

        <button type="submit">Submit</button>
      </form>
    </div>
  );
};

export default Lib3;
