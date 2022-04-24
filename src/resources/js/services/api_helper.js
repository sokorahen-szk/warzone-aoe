export const excludeNullParams = obj => {
    if (Object.keys(obj).length < 1) return {};
    Object.keys(obj).forEach(key => {
        if (obj[key] === undefined || obj[key] === null) {
            delete obj[key];
        }
    });
    return obj;
};

export const toString = ary => {
    if (!Array.isArray(ary)) return null;
    let l = ary.filter(item => {
        return item != null && item != "";
    });
    return l.join(",");
};

export const filterScopeDateFilter = (filter, date) => {
    let params = {};
    switch (filter.option) {
        case 0:
            params = Object.assign(params, filter.date);
            break;
        case 1:
            params = { begin_date: date.startOf("month").format("YYYY-MM-DD") };
            break;
        case 2:
            params = {
                begin_date: date
                    .subtract(1, "month")
                    .startOf("month")
                    .format("YYYY-MM-DD"),
                end_date: date
                    .subtract(1, "month")
                    .endOf("month")
                    .format("YYYY-MM-DD")
            };
            break;
        case 3:
            params = {
                begin_date: date.startOf("year").format("YYYY-MM-DD"),
                end_date: date.endOf("year").format("YYYY-MM-DD")
            };
            break;
        case 4:
            params = {
                begin_date: date
                    .subtract(1, "year")
                    .startOf("year")
                    .format("YYYY-MM-DD"),
                end_date: date
                    .subtract(1, "year")
                    .endOf("year")
                    .format("YYYY-MM-DD")
            };
            break;
    }

    return params;
};
