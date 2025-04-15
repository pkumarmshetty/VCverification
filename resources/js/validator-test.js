import validate from 'simple-data-validator';

// const result = validate({ data: { name: 'Inji' } });
// console.log(result);
export function validateData(data) {
    return validate(data);
}
